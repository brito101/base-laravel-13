@extends('errors.layout')

@section('title', '- 403 | Ooops! Acesso não autorizado!')
@section('error_image', asset('img/403-error.webp'))
@section('error_title', 'Ooops! Acesso não autorizado!')
@section('error_message', 'Sinto muito, mas você está tentando acessar uma área sem permissão!')
