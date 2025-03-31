<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function submit(Request $request)
    {
        // Aquí puedes manejar el envío del formulario
        return back()->with('success', '¡Tu mensaje ha sido enviado!');
    }
}
