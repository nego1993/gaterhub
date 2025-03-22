<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Routing\Route;
use Inertia\Inertia;

class MenuController extends Controller
{
    public function index()
    {
        $menus = Menu::orderBy('id', 'asc')->where('ic_ativo', 1)->get();
        return response()->json($menus);
    }

    public function menuIndex()
    {
        $menus = Menu::orderBy('id', 'asc')->get();
        return Inertia::render('Menu/MenuIndex', [
            'menus' => $menus,
        ]);
    }

    public function criarMenu()
    {
        return Inertia::render('Menu/MenuCreate');
    }

    public function salvarMenu()
    {
        request()->validate([
            'nm_menu' => ['required', 'max:255'],
            // 'nm_link' => ['required', 'max:255'],
            'sg_icon' => ['required', 'max:255'],
            'ic_ativo' => ['required', 'boolean'],
            'ic_raiz' => ['required', 'boolean'],
        ]);

        Menu::create([
            'nm_menu' => ucfirst(request('nm_menu')),
            'nm_link' => request('nm_link'),
            'sg_icon' => request('sg_icon'),
            'ic_ativo' => request('ic_ativo'),
            'ic_raiz' => request('ic_raiz'),
            'ic_parent' => request('ic_parent'),
        ]);

        return redirect()->route('menu.index');
    }

    public function atualizarMenu(Menu $menu)
    {
        request()->validate([
            'nm_menu' => ['required', 'max:255'],
            // 'nm_link' => ['required', 'max:255'],
            'sg_icon' => ['required', 'max:255'],
            'ic_ativo' => ['required', 'boolean'],
            'ic_raiz' => ['required', 'boolean'],
        ]);

        $menu->update([
            'nm_menu' => ucfirst(request('nm_menu')),
            'nm_link' => request('nm_link'),
            'sg_icon' => request('sg_icon'),
            'ic_ativo' => request('ic_ativo'),
            'ic_raiz' => request('ic_raiz'),
            'ic_parent' => request('ic_parent'),
        ]);

        return redirect()->route('menu.index');
    }
}