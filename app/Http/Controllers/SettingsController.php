<?php

namespace App\Http\Controllers;

class SettingsController extends Controller
{
    public function index()
    {
        return view('settings.company');
    }

    public function departmentsList()
    {
        return view('settings.departments.index');
    }

    public function departmentsCreate()
    {
        return view('settings.departments.form');
    }

    public function departmentsEdit($departmentId)
    {
        return view('settings.departments.form', compact('departmentId'));
    }

    public function departmentsShow($departmentId)
    {
        return view('settings.departments.show', compact('departmentId'));
    }

    public function emailIndex()
    {
        return view('settings.email');
    }

    public function backupIndex()
    {
        return view('settings.backup');
    }
}
