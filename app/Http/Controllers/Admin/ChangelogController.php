<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;

class ChangelogController extends Controller
{
    /** Releases and project details come from config/changelog.php. */
    public function index(): View
    {
        return view('admin.changelog.index', [
            'releases' => config('changelog.releases', []),
            'about' => config('changelog.about', []),
        ]);
    }
}
