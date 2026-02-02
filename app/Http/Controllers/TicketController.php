<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $projects = \App\Models\Project::all(['id', 'name']);
        return inertia('Ticket/Create', [
            'projects' => $projects,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'project_id' => 'required|exists:projects,id',
            'attachment' => 'nullable|file',
        ]);

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('attachments');
        }

        $ticket = \App\Models\Ticket::create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'project_id' => $validated['project_id'],
            'user_id' => $request->user()->id,
            'attachment_path' => $attachmentPath,
        ]);

        // Disparar job para processar o anexo
        \App\Jobs\ProcessTicketAttachment::dispatch($ticket);

        return redirect()->route('tickets.index')->with('success', 'Ticket criado com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
