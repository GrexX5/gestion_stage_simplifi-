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
                                <span class="badge bg-secondary">En attente de validation</span>
                            @elseif($convention->status === 'validated')
                                <span class="badge bg-success">Validée</span>
                            @elseif($convention->status === 'rejected')
                                <span class="badge bg-danger">Rejetée</span>
                            @endif
                            <div class="mt-1">
                                <small class="text-muted">
                                    Enseignant: 
                                    @if($convention->teacher_validated)
                                        <span class="text-success">✓ Validé</span>
                                    @else
                                        <span class="text-warning">En attente</span>
                                    @endif
                                </small>
                                <br>
                                <small class="text-muted">
                                    Entreprise: 
                                    @if($convention->company_validated)
                                        <span class="text-success">✓ Validé</span>
                                    @else
                                        <span class="text-warning">En attente</span>
                                    @endif
                                </small>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex gap-1">
                                <a href="{{ route('conventions.show', $convention->id) }}" class="btn btn-sm btn-outline-primary">Voir</a>
                                
                                @if($convention->status === 'pending')
                                    @if((Auth::user()->role === 'teacher' && !$convention->teacher_validated) || 
                                        (Auth::user()->role === 'company' && !$convention->company_validated))
                                        <form action="{{ route('conventions.validate', $convention->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-success">
                                                Valider
                                            </button>
                                        </form>
                                    @endif
                                    
                                    @if(in_array(Auth::user()->role, ['teacher', 'admin']))
                                        <form action="{{ route('conventions.reject', $convention->id) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                Rejeter
                                            </button>
                                        </form>
                                    @endif
                                @endif
                            </div>
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
