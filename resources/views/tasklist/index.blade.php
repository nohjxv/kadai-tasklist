@extends('layouts.app')

@section('content')

    <h1>タスクリスト一覧</h1>

    @if (count($tasklist) > 0)
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>id</th>
                    <th>タスクリスト</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($tasklist as $task)
                <tr>
                    {{-- メッセージ詳細ページへのリンク --}}
                    <td>{!! link_to_route('tasklist.show', $task->id, ['tasklist' => $task->id]) !!}</td>
                    <td>{{ $task->content }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif

@endsection