@extends('login-main')

@section('title', 'Электронное делопроизводство')

@section('header')
@include('login-menu')
@endsection

@section('content')
<div class="container">
    <div class="container">
        <div class="row justify-content-center ">
            <div class="col-md-8">

                <!-- The Modal -->
                <div class="modal fade" id="login" style="backdrop-filter: blur(20px)">
                    <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                
                        <!-- Modal Header -->
                        <div class="modal-header">
                            <h3>Авторизация</h3>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <form method="POST" action="/login">
                            @csrf
                            <!-- Modal body -->
                            <div class="modal-body">
                                <div class="row mb-3">
                                    <label for="email" class="col-md-4 col-form-label text-md-end">Email
                                        пользователя:</label>
                                    <div class="col-md-6">
                                        <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                                        @error('email')
                                        <div class="text-danger">{{$message}}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="password" class="col-md-4 col-form-label text-md-end">Пароль:</label>
                                    <div class="col-md-6">
                                        <input id="password" type="password" class="form-control" name="password" value="" required autocomplete="current-password">
                                        @error('password')
                                        <div class="text-danger">{{$message}}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <div class="col-md-6 offset-md-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remember" id="remember">
                                            <label class="form-check-label" for="remember">
                                                Запомнить
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <input  value="" hidden type="text" id="localTimeZone" name="localTimeZone">
                                </div>
                            </div>
  
                            <!-- Modal footer -->
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-secondary">Войти</button>
                            </div>
                        </form>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="tab-content">
    <div id="home" class="tab-pane active">
        <section id="first" style="
        background-image: url('{{asset('assets/images/edp(FHD).jpg')}}');
        height: 100vh;
        width: 100vw;
        background-position-x: left;
        background-position-y: top;
        background-repeat: no-repeat;
        background-size: cover;
        margin-top: -60px;">
        </section>

        <section id="first" style="
        background-image: url('{{asset('assets/images/third_section_background(FHD).jpg')}}');
        height: 100vh;
        width: 100vw;
        background-position-x: center;
        background-position-y: center;
        background-repeat: no-repeat;
        background-size: cover;
        margin-top: -20px;">
        </section>

        <section id="first" style="
        background-image: url('{{asset('assets/images/fourth_section_background(FHD).jpg')}}');
        height: 100vh;
        width: 100vw;
        background-position-x: center;
        background-position-y: center;
        background-repeat: no-repeat;
        background-size: cover;
        margin-top: -20px;">
        </section>

        <section id="first" style="
        background-image: url('{{asset('assets/images/abilities(FHD).jpg')}}');
        height: 100vh;
        width: 100vw;
        background-position-x: center;
        background-position-y: center;
        background-repeat: no-repeat;
        background-size: cover;
        margin-top: -20px;">
        </section>
    </div>

    <div id="description" class="tab-pane fade">
        <div class="container mb-3 mt-3 card shadow-lg">
            <div class="row">
                <div class="col-lg-2 col-md-12 rounded text-white bg-primary pt-3" style="--bs-bg-opacity: .4">
                    <div class="row">
                        <div class="col">
                            <h4 class="d-inline-block">Описание</h4>
                        </div>
                    </div>
                </div>
                <div class="col pt-3">
                    <h3>Приложение помогает решать задачи:</h3>
                    <ol style="font-size: 1.25em;">
                        <li>Ведение журналов регистрации входящих и исходящих документов, их хранение в формате pdf и полнотекстовый поиск по содержимому.</li>
                        <li>Контроль исполнения резолюций руководителя и иных поставленных задач.</li>
                        <li>Создание подзадач со своими сроками, исполнителями и периодичностью исполнения.</li>
                        <li>Получать уведомления о появлении новых задач, сводку о запланированных задачах на неделю, и напоминание о просроченных задачах.</li>
                        <li>Создавать и вести список сотрудников организации с учетом структуры организации с разграничением прав доступа к разделам приложения.</li>
                        <li>Автоматически формировать телефонный справочник организации.</li>
                        <li>Перераспределять исполнение задач отсутствующих сотрудников.</li>
                        <li>Анализировать исполнительность сотрудников.</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div id="demonstration" class="tab-pane fade">
        <div class="container mb-3 mt-3 card shadow-lg">
            <div class="row">
                <div class="col-lg-2 col-md-12 rounded text-white bg-primary pt-3" style="--bs-bg-opacity: .4">
                    <div class="row">
                        <div class="col">
                            <h4 class="d-inline-block">Демонстрация</h4>
                        </div>
                    </div>
                </div>
                <div class="col pt-3">
                    <h3>Протестировать работу приложения можно прямо здесь:</h3>
                    <p>Для начала тестирования достаточно выполнить вход в любую из указанной ниже учетных записей.</p>
                    <p>Для наглядности работы приложение заполнено фэйковыми данными, в том числе сотрудникам организации со структурой подчинения и должностями.</p>
                    <p>Должности (роли) определяют доступность работы с теми или иными данными. Например, делопроизводителю доступа регистрация документов, 
                        кадровику - управление сотрудниками, руководителю организации - рассмотрение документов и добавление резолюций на документ для исполнения, 
                        администратору - управление приложением.</p>
                    <p>Для демонстрации создана простая структура предприятия: Руководителю предприятия подчинены администратор, кадровик, делопроизводитель и начальники четырех отделов. 
                        В каждом отдете имеется по четыре сотрудника. В процессе тестирования доступно любое изменение, добавление и удаление сотрудников и любых других данных.</p>
                    <p>В начале каждого часа происходит сброс всех изменений к исходному состоянию.</p>
                    <p>Для получения полного представления о взаимодействии между сотрудниками тестирование лучше проводить группой коллег или друзей.</p>
                    <p>Для получения полного представления о возможностях при работе с документами файл pdf должен иметь русскоязычный текстовый слой.</p>
                    <p>
                        <b>Список демонстрационных учетных записей:</b>
                        <ol>
                            <li>boss@boss.ru - Руководитель организации</li>
                            <li>admin@admin.ru - Администратор приложения</li>
                            <li>delo@delo.ru - Делопроизводитель организации</li>
                            <li>kadr@kadr.ru - Кадровик организации</li>
                            <li>o1@o1.ru ... o4@o4.ru - Начальник отдела организации (для демонстрации создано 4 отдела)</li>
                            <li>o1s1@o1s1.ru ... o1s4@o1s4.ru - Сотрудник соответствующего отдела (для демонстрации создано по 4 сотрудника в отделе)</li>
                        </ol>
                    </p>
                    <p>пароль для всех одинаковый:+1234567</p>
                    <p>Подробнее о работе в приложении можно прочитать в документации.</p>
                </div>
            </div>
        </div>
    </div>

    <div id="development" class="tab-pane fade">
        <div class="container mb-3 mt-3 card shadow-lg">
            <div class="row">
                <div class="col-lg-2 col-md-12 rounded text-white bg-primary pt-3" style="--bs-bg-opacity: .4">
                    <div class="row">
                        <div class="col">
                            <h4 class="d-inline-block">Развитие приложения</h4>
                        </div>
                    </div>
                </div>
                <div class="col pt-3">
                    <h5>Розработка</h5>
                    <p>Приложение доступно для использования на безвозмездной основе без ограничений срока, функционала и количества сотрудников.</p>
                    <h5>Помощь в развитии.</h5>
                    <p>Оказать помощь в развитии приложения можно в виде доната: ____________, 
                        <br>заключения договора на техническое сопровождение или заказ персональных функций.</p>
                    <h5>Планируемые к разработке функции:</h5>
                    <ul>
                        <li>Расчет трудового стажа сотрудников</li>
                        <li>Планирование и учет отпусков сотрудников</li>
                        <li>Страница эффективности сотрудников</li>
                    </ul>
                    <h5>История:</h5>
                    <ul>
                        <li>07.07.2023 Улучшена адаптация интерфейса для экрана телефона</li>
                        <li>19.06.2023 Перевод документов в архив с помощью обработчика событий приложения.</li>
                        <li>22.04.2023 Добавлен фильтр дат для документов</li>
                        <li>16.04.2023 Изменен интерфейс форм</li>
                        <li>06.03.2023 Реализована работа с таблицами архива</li>
                        <li>16.02.2003 Добавлен автоматический перевод старых документов в архив.</li>
                        <li>14.02.2023 Добавлен полнотекстовый поиск по содержимому документов</li>
                        <li>09.02.2023 Добавлена рассылка списка просроченных задач и задач на неделю</li>
                        <li>07.02.2023 Добавлено уведомление о новой задаче</li>
                        <li>03.02.2003 Повышена безопасность приложения</li>
                        <li>31.01.2023 Добавлено извлечение текста из документа PDF</li>
                        <li>26.01.2023 Повышена безопасность приложения</li>
                        <li>21.01.2023 Добавлен справочник телефонных номеров сотрудников</li>
                        <li>20.01.2023 Добавлена обработка локального часового пояса</li>
                        <li>19.01.2023 Добавлена возможность сохранять приложение к документу</li>
                        <li>16.01.2023 Добавлены статусы сотрудников</li>
                        <li>14.01.2023 Добавлены роли сотрудников</li>
                        <li>04.01.2023 Добавлена возможность работы с документами</li>
                        <li>23.12.2022 Добавлена возможность работы с задачами</li>
                        <li>20.12.2022 Начало работы над приложением</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('localTimeZone').value = Intl.DateTimeFormat().resolvedOptions().timeZone;
</script>
@endsection
