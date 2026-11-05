@extends('errors.layout')

@section('title', '- 414 | Oops! Requisição muito longa!')
@section('error_image', asset('img/414-error.webp'))
@section('error_title', 'Oops! Requisição muito longa!')
@section('error_message', 'A URL acessada está com um parâmetro muito longo. Limite os itens selecionados e tente novamente.')
