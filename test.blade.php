{{-- Echo Data --}}
Hello, {{ $name }}.
The current UNIX timestamp is {{ time() }}.

{{-- Echoing Data After Checking For Existence --}}
{{ isset($name) ? $name : 'Default' }}
{{ $name or 'Default' }}

{{-- Displaying Raw Text With Curly Braces --}}
@{{ This will not be p<p></p>rocessed by Blade }}

{{-- Do not escape data --}}
Hello, {!! $name !!}.

{{-- Escape Data --}}
Hello, {{{ $name }}}.

<?php echo $name; ?>
<?= $name; ?>

<?php
    foreach (range(1, 10) as $number) {
        echo $number;
    }
?>

@include('header')

{{-- Service injection --}}
@inject('metrics', 'App\Services\MetricsService')

{{-- PHP open/close tags --}}
<div class="container">
    @php
        foreach (range(1, 10) as $number) {
            echo $number;
        }
    @endphp
</div>

{{-- Inline PHP --}}
<div class="container">
    @php(custom_function())
    @php($bool = $var ?? false)
    @php($bool = $bool ?: true)
</div>

@include('footer')

{{-- Define Blade Layout --}}
<html>
    <head>
        <title>
            @hasSection('title')
                @yield('title') - App Name
            @else
                App Name
            @endif
        </title>
    </head>
    <body>
        @section('sidebar')
            This is the master sidebar.
        @stop

        <div class="container">
            @yield('content')
        </div>
    </body>
</html>

{{-- Use Blade Layout --}}
@extends('layouts.master')

@section('sidebar')
    <p>This is appended to the master sidebar.</p>
@stop

@section('content')
    <p>This is my body content.</p>
@stop

{{-- yield section --}}
@yield('section', 'Default Content')

{{-- If Statement --}}
@if (count($records) === 1)
    I have one record!
@elseif (count($records) > 1)
    I have multiple records!
@else
    I don't have any records!
@endif

<ul class="list @if (count($records) === 1) extra-class @endif">
    <li>This is the first item</li>
    <li>This is the second item</li>
</ul>

@isset($name)
    Hello, {{ $name }}.
@endisset

@empty($name)
    Hello, {{ $name }}.
@endempty

@unless (Auth::check())
    You are not signed in.
@endunless

{{-- Loops --}}
@for ($i = 0; $i < 10; $i++)
    The current value is {{ $i }}
@endfor

@foreach ($users as $user)
    <p>This is user {{ $user->id }}</p>
@endforeach

@forelse($users as $user)
    <li>{{ $user->name }}</li>
@empty
    <p>No users</p>
@endforelse

@while (true)
    <p>I'm looping forever.</p>
@endwhile

{{-- Include --}}
@include('view.name')
@include('view.name', ['some' => 'data'])
@includeIf('view.name', ['some' => 'data'])

{{-- Overwriting Sections --}}
@extends('list.item.container')

@section('list.item.content')
    <p>This is an item of type {{ $item->type }}</p>
@overwrite

{{-- Displaying Language Lines --}}
@lang('language.line')

@choice('language.line', 1)

{{-- This comment will not be in the rendered HTML --}}

{{--
This comment will not be in the rendered HTML
This comment will not be in the rendered HTML
This comment will not be in the rendered HTML
 --}}

{{-- Blade Extensions Compatibility --}}
{{-- https://github.com/RobinRadic/blade-extensions --}}
@foreach($stuff as $key => $val)
    {{ $loop->index }}       {{-- int, zero based --}}
    {{ $loop->first }}       {{-- bool --}}
    {{ $loop->last }}        {{-- bool --}}
    {{ $loop->even }}        {{-- bool --}}
    {{ $loop->odd }}         {{-- bool --}}
    {{ $loop->length }}      {{-- int --}}

    @foreach($other as $name => $age)

        {{ $loop->parent->odd }}

        @foreach($friends as $foo => $bar)

            {{ $loop->parent->index }}
            {{ $loop->parent->parentLoop->index }}

        @endforeach

    @endforeach

    {{-- with arguments --}}
    @continue($user->type == 1)
    @break($user->number == 5)

    {{-- without arguments --}}
    @break
    @continue

@endforeach

@unset('newvar')
@unset($newvar)

{{-- Authorization (ACL) --}}

@can('permission', $entity)
    You have permission!
@endcan

@can('permission', $entity)
    You have permission!
@else
    You don't have permission!
@endcan

@cannot ('update', [ 'post' => $post ])
    breeze
@endcannot

@can ('show-post', $post)
    Can Show
@elsecan ('write-post', $post)
    Can write
@elsecannot ('delete-post', $post)
    Not Allowed
@else
    Not Allowed
@endcan

@canany (['show-post', 'write-post'])
    Can Show or write
@elsecanany (['update-post', 'delete-post'])
    Can update or delete
@endcanany

{{-- Stacks --}}
@push('scripts')
    <script src="/example.js"></script>
@endpush

<head>
    @stack('scripts')
</head>

{{-- Custom Control Structures --}}
@custom

@foo('bar', 'baz')
    @datetime($var)

@json($data)


{{-- Envoyer directives --}}

@setup
    $now = new DateTime();

    $environment = isset($env) ? $env : "testing";
@endsetup

@servers(['web' => 'user@192.168.1.1'])

@task('foo')
    cd site
    git pull origin {{ $branch }}
    php artisan migrate
@endtask

@after
    @hipchat('token', 'room', 'Envoy')
    @slack('hook', 'channel', 'message')
@endafter

@story('deploy')
    git
    composer install
@endstory

@component('layouts.app')
    @slot('title')
        Home Page
    @endslot

    <div class="col-6">
        @component('inc.alert')
            This is the alert message here.
        @endcomponent
        <h1>Welcome</h1>
    </div>
    <div class="col-6">
        @component('inc.sidebar')
            This is my sidebar text.
        @endcomponent
    </div>

    @includeWhen(Auth::user(), 'nav.user')
@endcomponent

@verbatim
    <div class="container">
        Hello, {{ $name }}.
    </div>
@endverbatim

@switch($char)
    @case('A')
        <p>A</p>
    @break

    @case('B')
        <p>B</p>
    @break

    @default
        <p>Default</p>
@endswitch

{{-- Complex conditional --}}
@if(($x == true) && ($y == false))
    <a>foo</a>
@endif

{{-- Single line if statement --}}
@if($foo === true) <p>Text</p> @endif

{{-- Quoted blade directive matching --}}
<p class="first-class @if($x==true) second-class @endif">Text</p>

{{-- Complex conditional inline --}}
<p class="first-class @if(($x == true) && ($y == "yes")) second-class @endif">Text</p>

{{-- Helpers --}}
@csrf
@dd('Compile the "dd" statements into valid PHP.')
@dump('Compile the "dump" statements into valid PHP')
@method('post')

{{-- Validation Errors --}}
@error('title')
@enderror

{{-- Livewire --}}
@livewireStyles
@livewireScripts
@livewire('show-contact', ['contact' => $contact])
