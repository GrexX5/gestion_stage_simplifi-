@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">@if(Auth::user()->role === 'company') Candidatures reçues @else Mes candidatures @endif</h2>

    {{-- Feedback messages --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Stage</th>
                    <th>Entreprise</th>
                    <th>Étudiant</th>
                    <th>Statut</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($applications as $application)
                    <tr>
                        <td>{{ $application->internship->title ?? '-' }}</td>
                        <td>{{ $application->internship->company->name ?? '-' }}</td>
                        <td>{{ $application->student->user->name ?? '-' }}</td>
                        <td>
                            @if($application->status === 'pending')
                                <span class="badge bg-secondary">En attente</span>
                            @elseif($application->status === 'accepted')
                                <span class="badge bg-success">Acceptée</span>
                            @elseif($application->status === 'rejected')
                                <span class="badge bg-danger">Refusée</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('applications.show', $application->id) }}" class="btn btn-sm btn-outline-primary">Voir</a>
                            @if(Auth::user()->role === 'company' && $application->status === 'pending')
                                <form action="{{ route('applications.updateStatus', $application) }}" method="POST" class="d-inline ms-1">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="accepted">
                                    <button type="submit" class="btn btn-sm btn-success">Accepter</button>
                                </form>
                                <form action="{{ route('applications.updateStatus', $application) }}" method="POST" class="d-inline ms-1">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="rejected">
                                    <button type="submit" class="btn btn-sm btn-danger">Refuser</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center">Aucune candidature.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
