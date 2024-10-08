<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        /*'productos/*',  // Excluir todas las rutas que coincidan con productos/*
        'productos',  // Excluir todas las rutas que coincidan con productos/*

        'categorias/*',  // Excluir todas las rutas que coincidan con productos/*
        'categorias',  // Excluir todas las rutas que coincidan con productos/*

        'usuarios/*',  // Excluir todas las rutas que coincidan con productos/*
        'usuarios',  // Excluir todas las rutas que coincidan con productos/*

        
        'api/*',  // Excluir todas las rutas que coincidan con productos/*
        'api',  // Excluir todas las rutas que coincidan con productos/** 
        */
    ];
}
