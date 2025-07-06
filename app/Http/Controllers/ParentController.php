<?php

namespace App\Http\Controllers;

use App\Models\ParentModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ParentController extends Controller
{
    public function index()
    {
        $parents = ParentModel::with('students')->get();
        return view('parents.index', compact('parents'));
    }

    public function create()
    {
        return view('parents.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'phone'    => 'required|string|max:20|unique:parent_models,phone',
            'password' => 'required|string|min:6',
        ]);

        ParentModel::create([
            'name'     => $request->name,
            'phone'    => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('parents.index')->with('success', 'تمت إضافة ولي الأمر بنجاح');
    }

    public function show($id)
    {
        $parent = ParentModel::with('students.class')->findOrFail($id);
        return view('parents.show', compact('parent'));
    }

    public function edit($id)
    {
        $parent = ParentModel::findOrFail($id);
        return view('parents.edit', compact('parent'));
    }

    public function update(Request $request, $id)
    {
        $parent = ParentModel::findOrFail($id);

        $request->validate([
            'name'     => 'required|string|max:255',
            'phone'    => 'required|string|max:20|unique:parent_models,phone,' . $parent->id,
            'password' => 'nullable|string|min:6',
        ]);

        $parent->name = $request->name;
        $parent->phone = $request->phone;

        if ($request->filled('password')) {
            $parent->password = Hash::make($request->password);
        }

        $parent->save();

        return redirect()->route('parents.index')->with('success', 'تم التحديث بنجاح');
    }

    public function destroy($id)
    {
        $parent = ParentModel::findOrFail($id);
        $parent->delete();

        return redirect()->route('parents.index')->with('success', 'تم حذف ولي الأمر');
    }
}
