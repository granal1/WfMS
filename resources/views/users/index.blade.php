@extends('main')

@section('title', 'Главная | Сотрудники')

@section('header')
@include('menu')
@endsection

@section('content')
<div class="container pt-3">
    <div class="card shadow">
        <div class="card-header">
            <div class="d-grid gap-2 d-md-flex align-items-center justify-content-between">
                <a class="btn btn-outline-success btn-sm" href="{{route('users.create')}}">Добавить</a>
                <h4 class="d-inline-block">Сотрудники</h4>
                        <button class="btn btn-outline-primary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Поиск
                        </button>
                <a class="btn btn-outline-danger btn-sm d-md-none" type="button" href="{{route('users.index')}}">Сброс</a>
            </div>
        </div>
        <div class="card-body">
            <div class="row pt-3">
                <div class="col">
                    <table class="table table-sm table-hover table-striped">
                        <thead>
                            <tr>
                                <th class="d-none d-sm-table-cell">Имя</th>
                                <th class="d-none d-sm-table-cell">Должность</th>
                                <th class="d-none d-sm-table-cell">Роль</th>
                                <th class="d-none d-sm-table-cell">Телефон</th>
                                <th class="d-none d-sm-table-cell">Почта</th>
                                <th class="d-none d-sm-table-cell">Д/рождения</th>
                                <th class="d-none d-sm-table-cell">Д/трудоустр.</th>
                                <th class="d-none d-md-table-cell">Статус</th>
                            </tr>
                        </thead>
                        <tbody style="cursor: pointer;">
                            <tr class="collapse @if(!empty($old_filters)) show @endif" id="collapseExample">
                                <form action="{{ route('users.index') }}" method="get">
                                    <td class="d-none d-md-table-cell"><a class="btn btn-outline-danger btn-sm" type="button" href="{{route('users.index')}}">Сброс</a></td>
                                    <td>
                                        <input type="search" value="@if(isset($old_filters['name'])){{$old_filters['name']}}@endif" class="form-control form-control-sm" id="name" name="name" onchange="this.form.submit()">
                                    </td>
                                    <td class="d-none d-sm-table-cell">
                                        <input type="search" value="@if(isset($old_filters['email'])){{$old_filters['email']}}@endif" class="form-control form-control-sm" id="email" name="email" onchange="this.form.submit()">
                                    </td>
                                </form>
                            </tr>
                            @forelse($users as $user)
                            <tr onclick="window.location='{{ route('users.show', $user->id) }}';">
                                <td class="d-none d-sm-table-cell">{{$user->name}}</td>
                                <td class="d-none d-sm-table-cell">{{$user->position}}</td>
                                <td class="d-none d-sm-table-cell">
                                    @forelse($user->roles as $user_role)
                                        {{$user_role->alias}} <br>
                                    @empty
                                        Нет ролей
                                    @endforelse
                                </td>
                                <td class="d-none d-sm-table-cell">{{$user->phone}}</td>
                                <td class="d-none d-sm-table-cell">{{$user->email}}</td>
                                <td class="d-none d-sm-table-cell">{{$user->birthday_at}}</td>
                                <td class="d-none d-sm-table-cell">{{$user->employment_at}}</td>
                                <td class="d-none d-md-table-cell">{{$user->status->name}}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6">
                                    Нет пользователей
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{$users->withQueryString()->links()}}
                </div>
            </div>
        </div>
        @endsection
