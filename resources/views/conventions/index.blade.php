@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Liste des conventions</h2>
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Stage</th>
                    <th>Étudiant</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($conventions as $convention)
                    <tr>
                        <td>{{ $convention->application->internship->title ?? '-' }}</td>
                        <td>{{ $convention->application->student->user->name ?? '-' }}</td>
                        <td>
                            @if($convention->status === 'pending')
                                <span class="badge bg-secondary">En attente</span>
                            @elseif($convention->status === 'validated')
                                <span class="badge bg-success">Validée</span>
                            @elseif($convention->status === 'rejected')
                                <span class="badge bg-danger">Rejetée</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('conventions.show', $convention->id) }}" class="btn btn-sm btn-outline-primary">Voir</a>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="text-center">Aucune convention.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
