@extends('main')

@section('title', 'Главная | Роли')

@section('header')
    @include('menu')
@endsection

@section('content')
    <div class="container pt-3">
        <div class="card shadow">
            <div class="card-header">
                <div class="d-grid gap-2 d-md-flex align-items-center justify-content-between">
                    <h4 class="d-inline-block">Роли</h4>
                    <button class="btn btn-outline-primary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Поиск
                    </button>
                        <a class="btn btn-outline-danger btn-sm d-sm-none" type="button" href="{{route('roles.index')}}">Сброс</a>
                </div>
            </div>
            <div class="card-body">
                <div class="row pt-3">
                    <div class="col">
                        <table class="table table-sm table-hover table-striped">
                            <thead>
                            <tr>
                                <th>Название</th>
                                <th colspan="2">Алиас</th>
                            </tr>
                            </thead>
                            <tbody style="cursor: pointer;">

                            <tr class="collapse @if(!empty($old_filters)) show @endif" id="collapseExample">
                                <form action="{{ route('roles.index') }}" method="get">
                                    <td>
                                        <input type="search" value="@if(isset($old_filters['alias'])){{$old_filters['alias']}}@endif"
                                               class="form-control form-control-sm" id="alias" name="alias"
                                               onchange="this.form.submit()">
                                    </td>
                                    <td>
                                        <input type="search" value="@if(isset($old_filters['name'])){{$old_filters['name']}}@endif"
                                               class="form-control form-control-sm" id="name" name="name"
                                               onchange="this.form.submit()">
                                    </td>
                                    <td class="d-none d-sm-table-cell"><a class="btn btn-outline-danger btn-sm" type="button" href="{{route('roles.index')}}">Сброс</a></td>
                                </form>
                            </tr>
                            @forelse($roles as $role)
                                <tr  onclick="window.location='{{ route('roles.show', $role->id) }}';">
                                    <td>{{$role->alias}}</td>
                                    <td colspan="2">{{$role->name}}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2">
                                        Нет ролей
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                        {{$roles->withQueryString()->links()}}
                    </div>
                </div>
            </div>
        </div>
@endsection

