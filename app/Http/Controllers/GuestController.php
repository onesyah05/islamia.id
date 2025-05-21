<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GuestController extends Controller
{
    public function index() { return view('front.pages.home'); }
    public function create() { return view('front.pages.create'); }
    public function store(Request $request) { /* logic */ }
    public function show($id) { return view('front.pages.show', compact('id')); }
    public function edit($id) { return view('front.pages.edit', compact('id')); }
    public function update(Request $request, $id) { /* logic */ }
    public function destroy($id) { /* logic */ }
} 