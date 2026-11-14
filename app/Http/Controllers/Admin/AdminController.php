<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Visit as LogVisit;
use App\Models\Views\User as ViewsUser;
use App\Models\Views\Visit;
use App\Models\Views\VisitYesterday;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use stdClass;
use Yajra\DataTables\Facades\DataTables;

class AdminController extends Controller
{
    /**
     * Perfis que podem ver logs de visitas e estatísticas de acesso.
     * Deve acompanhar os @if (hasRole(...)) de admin/home/index.blade.php.
     */
    private const AUDIT_ROLES = 'Programador|Administrador';

    /**
     * Padrões de URL ignorados nos logs exibidos e nas estatísticas.
     */
    private const IGNORED_URL_PATTERNS = [
        '%columns%',
        '%storage%',
        // '%admin%',
        '%offline%',
        '%manifest.json%',
        '%.png%',
        '%code=%',
        '%_token=%',
    ];

    /**
     * Colunas carregadas na listagem. "request" e "headers" ficam de fora:
     * são cifrados e só devem ser lidos em auditoria (App\Models\Visit).
     */
    private const TABLE_COLUMNS = [
        'id', 'created_at', 'url', 'ip', 'useragent', 'platform',
        'browser', 'name', 'method',
    ];

    public function index(Request $request)
    {
        $canAudit = $this->canAudit($request);

        if ($request->ajax()) {
            abort_unless($canAudit, 403);

            return $this->visitsTable();
        }

        $statistics = $canAudit
            ? $this->accessStatistics()
            : ['onlineUsers' => 0, 'access' => 0, 'percent' => 0, 'chart' => $this->emptyChart()];

        return view('admin.home.index', [
            'administrators' => $canAudit ? ViewsUser::where('type', 'Administrador')->count() : 0,
            'onlineUsers' => $statistics['onlineUsers'],
            'percent' => $statistics['percent'],
            'access' => $statistics['access'],
            'chart' => $statistics['chart'],
        ]);
    }

    public function chart(Request $request): JsonResponse
    {
        abort_unless($this->canAudit($request), 403);

        return response()->json($this->accessStatistics());
    }

    private function canAudit(Request $request): bool
    {
        return (bool) $request->user()?->hasRole(self::AUDIT_ROLES);
    }

    /**
     * Paginação, busca e ordenação no banco (server-side), em vez de
     * carregar todos os registros do dia (com seus payloads cifrados).
     */
    private function visitsTable(): JsonResponse
    {
        $query = $this->withoutIgnoredUrls(Visit::query())->select(self::TABLE_COLUMNS);

        return DataTables::eloquent($query)
            ->addColumn('time', fn ($row) => $row->created_at
                ? date('H:i:s', strtotime($row->created_at))
                : '')
            ->orderColumn('time', 'created_at $1')
            ->editColumn('url', fn ($row) => LogVisit::redactedUrl($row->url))
            ->addIndexColumn()
            ->toJson();
    }

    private function accessStatistics(): array
    {
        // Agregação no banco: apenas contagens por hora, sem trazer linhas.
        $perHour = $this->withoutIgnoredUrls(Visit::query())
            ->where('method', 'GET')
            ->selectRaw('HOUR(created_at) as hour, COUNT(*) as total')
            ->groupBy('hour')
            ->orderBy('hour')
            ->pluck('total', 'hour');

        $totalDaily = (int) $perHour->sum();

        $totalYesterday = $this->withoutIgnoredUrls(VisitYesterday::query())
            ->where('method', 'GET')
            ->count();

        // Variação em relação ao dia anterior.
        $percent = 0;
        if ($totalYesterday > 0) {
            $percent = number_format(($totalDaily - $totalYesterday) / $totalYesterday * 100, 2, ',', '.');
        }

        $chart = $this->emptyChart();
        foreach ($perHour as $hour => $total) {
            $chart->labels[] = sprintf('%02dH', $hour);
            $chart->dataset[] = (int) $total;
        }

        return [
            'onlineUsers' => User::online()->count(),
            'access' => $totalDaily,
            'percent' => $percent,
            'chart' => $chart,
        ];
    }

    private function withoutIgnoredUrls(Builder $query): Builder
    {
        $query->where('url', '!=', route('admin.home.chart'));

        foreach (self::IGNORED_URL_PATTERNS as $pattern) {
            $query->where('url', 'NOT LIKE', $pattern);
        }

        return $query;
    }

    private function emptyChart(): stdClass
    {
        $chart = new stdClass;
        $chart->labels = [];
        $chart->dataset = [];

        return $chart;
    }
}
