@extends('main')

@section('title', 'Создание документа')

    @section('header')
        @include('menu')
    @endsection

    @section('content')
    <div class="container pt-3 mb-3 mt-3 card shadow-lg">
        <div class="row row-cols-1 row-cols-md-2">
            <div class="col">
                <h4 class="d-inline-block">Новый документ</h4>
            </div>
        </div>
        @include('message')

        <form action="{{route('documents.store')}}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="row row-cols-1 row-cols-md-2 mt-3">
                <div class="col text-end">
                    <label for="incoming_at" class="form-label">Дата входящего</label>
                </div>
                <div class="col">
                    <input type="date" id="incoming_at" name="incoming_at" class="form-control form-select-sm" value="{{date('Y-m-d')}}">
                    @error('incoming_at')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="row row-cols-1 row-cols-md-2 mt-3">
                <div class="col text-end">
                    <label for="incoming_number" class="form-label">Номер входящего документа</label>
                </div>
                <div class="col">
                    <input type="text" class="form-control form-control-sm" id="incoming_number" placeholder="Номер" name="incoming_number">
                    @error('incoming_number')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="row row-cols-1 row-cols-md-2 mt-3">
                <div class="col text-end">
                    <label for="document_file" class="form-label">Загрузить документ</label>
                </div>
                <div class="col">
                    <input accept=".pdf" required class="form-control form-control-sm" name="file" id="document_file" type="file">
                    @error('file')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="row row-cols-1 row-cols-md-2 mt-3">
                <div class="col text-end">
                    <label for="archive_file" class="form-label">Загрузить архив приложение к документу</label>
                </div>
                <div class="col">
                    <input accept=".zip" class="form-control form-control-sm" name="archive_file" id="archive_file" type="file">
                    @error('archive_file')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="row row-cols-1 row-cols-md-2 mt-3">
                <div class="col text-end">
                    <label for="short_description">Наименование или краткое содержание</label>
                </div>
                <div class="col">
                    <input placeholder="Наименование" class="form-control form-control-sm" name="short_description" id="document_name">
                    @error('short_description')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="row row-cols-1 row-cols-md-2 mt-3">
                <div class="col text-end">
                    <label for="incoming_author" class="form-label">Корреспондент (автор)</label>
                </div>
                <div class="col">
                    <input type="text" class="form-control form-control-sm" id="incoming_author" placeholder="Корреспондент (автор)" name="incoming_author">
                    @error('incoming_author')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="row row-cols-1 row-cols-md-2 mt-3">
                <div class="col text-end">
                    <label for="number" class="form-label">Номер</label>
                </div>
                <div class="col">
                    <input type="text" class="form-control form-control-sm" id="number" placeholder="Номер" name="number">
                    @error('number')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="row row-cols-1 row-cols-md-2 mt-3">
                <div class="col text-end">
                    <label for="date" class="form-label">Дата</label>
                </div>
                <div class="col">
                    <input type="date" id="date" name="date" class="form-control form-select-sm" placeholder="Дата">
                    @error('date')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>
            <div class="row row-cols-1 row-cols-md-2 mt-3">
                <div class="col text-end">
                    <label for="document_and_application_sheets" class="form-label">Количество листов документа, включая приложение</label>
                </div>
                <div class="col">
                    <input type="text" class="form-control form-control-sm" id="document_and_application_sheets" placeholder="укажите количество листов" name="document_and_application_sheets">
                    @error('document_and_application_sheets')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
            </div>

            <div class="row mt-4 mb-4">
                <div class="col text-end">
                    <button type="button" style="width:100px" class="btn btn-success btn-sm"  onclick="javascript:history.back(); return false;">Назад</button>
                </div>
                <div class="col">
                    <button type="submit" style="width:100px" class="btn btn-danger btn-sm">Сохранить</button>
                </div>
            </div>
            
        </form>
    </div>
</div>
        <script src="{{asset('assets/documents/create.js')}}"></script>
    @endsection



