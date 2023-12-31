@extends('main')

@section('title', 'Главная | Задачи')

@section('header')
@include('menu')
@endsection

@section('content')
<div class="container pt-3">
    <div class="card shadow">
        <div class="card-header">
            <div class="d-grid gap-2 d-md-flex align-items-center justify-content-between">
                @auth
                    <a class="btn btn-outline-success btn-sm" href="{{route('tasks.create')}}">Добавить</a>
                @endauth
                <h4 class="d-inline-block">Задачи</h4>
                        <button class="btn btn-outline-primary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Поиск
                        </button>
                    <a class="btn btn-outline-danger btn-sm d-sm-none" type="button" href="{{route('tasks.index')}}">Сброс</a>
            </div>
        </div>
        <div class="card-body">
            <div class="row pt-3">
                <div class="col">
                    <table class="table table-sm table-hover table-striped">
                        <thead>
                            <tr>
                                <th class="d-sm-table-cell">Срок</th>
                                <th class="d-none d-md-table-cell">Приоритет</th>
                                <th class="d-sm-table-cell">Исполнитель</th>
                                <th class="d-sm-table-cell">Задача</th>
                                <th class="d-none d-md-table-cell">Отчет</th>
                                <th class="d-sm-table-cell">Исп.,&nbsp;%</th>
                                <th class="d-none d-md-table-cell">Исполнено</th>
                            </tr>
                        </thead>
                        <tbody style="cursor: pointer;">

                            <tr class="collapse @if(!empty($old_filters)) show @endif" id="collapseExample">
                                <form action="{{ route('tasks.index') }}" method="get">
                                    <td class="d-none d-sm-table-cell"></td>
                                    <td class="d-none d-sm-table-cell">
                                        <select class="form-select form-select-sm" name="priority_uuid" id="priority_uuid" onchange="this.form.submit()">
                                            <option value="">Выберите ...</option>
                                            @forelse($priorities as $priority)
                                                <option @if(isset($old_filters['priority_uuid'])) {{$priority->id === $old_filters['priority_uuid'] ? 'selected' : ''}}  @endif value="{{$priority->id}}">{{$priority->name}}</option>
                                            @empty
                                                <option value="">Нет приоритетов</option>
                                            @endforelse
                                        </select>
                                    </td>
                                    <td class="d-none d-sm-table-cell"></td>
                                    <td>
                                        <input type="search" value="@if(isset($old_filters['description'])){{$old_filters['description']}}@endif" class="form-control form-control-sm" id="description" name="description" onchange="this.form.submit()">
                                    </td>
                                    <td class="d-none d-sm-table-cell"></td>
                                    <td class="d-none d-md-table-cell"></td>
                                    <td class="d-none d-sm-table-cell"><a class="btn btn-outline-danger btn-sm" type="button" href="{{route('tasks.index')}}">Сброс</a></td>
                                </form>
                            </tr>
                            @forelse($tasks as $task)
                            <tr onclick="window.location='{{ route('tasks.show', $task->id) }}';">
                                <td class="d-sm-table-cell">{{$task->deadline_at}}</td>
                                <td class="d-none d-md-table-cell">{{$task->priority->name}}</td>
                                <td class="d-sm-table-cell">{{$task->responsible->name}}</td>
                                <td class="d-sm-table-cell">{{$task->description}}</td>
                                <td class="d-none d-md-table-cell">{{$task->report}}</td>
                                <td class="d-sm-table-cell">@include('graph.progressbar', ['done_progress'=> $task->done_progress])</td>
                                <td class="d-none d-md-table-cell">{{$task->executed_at ?? 'нет'}}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6">
                                    Нет задач
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{$tasks->withQueryString()->links()}}
                </div>
            </div>
        </div>
    </div>
    @endsection
