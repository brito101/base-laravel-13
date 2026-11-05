@props(['active' => false, 'on' => 'Ativo', 'off' => 'Inativo', 'onColor' => 'success', 'offColor' => 'secondary'])

<span class="badge text-bg-{{ $active ? $onColor : $offColor }}">{{ $active ? $on : $off }}</span>
