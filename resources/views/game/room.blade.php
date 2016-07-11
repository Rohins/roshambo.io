@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Room: @{{room}}</div>
                <div class="panel-body">
                    
                    <button 
                        class="btn" 
                        v-if="seats.seat1 === null"
                        v-on:click="sitdown(room, 1, '{{ Auth::user()->name }}')"
                    >
                        Seat 1
                    </button>
                    
                    <button 
                        class="btn"
                        v-else 
                        v-on:click="standup(room, 1, '{{ Auth::user()->name }}')"
                    >
                        @{{seats.seat1}}
                    </button>
                    
                    <button 
                        v-if="seats.seat2 === null"
                        class="btn pull-right" 
                        v-on:click="sitdown(room, 2, '{{ Auth::user()->name }}')"
                    >
                            Seat 2
                    </button>
                    
                    <button 
                        class="btn pull-right"
                        v-else 
                        v-on:click="standup(room, 2, '{{ Auth::user()->name }}')"
                    >
                        @{{seats.seat2}}
                    </button>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    var socket = io('http://50.116.47.108:3000');

    var vue = new Vue({
        el: 'body',

        data: {
            room: '{{$room}}',
            seats: []
        },

        methods: {
            sitdown: function(room, seat, user) {
                $.ajax({
                    type: "POST",
                    url:  "/api/room/sitdown",
                    data: {
                        room: room,
                        user: user,
                        seat: seat
                    },
                    success: function(data) {
                    }
                });
            },
            standup: function(room, seat, user) {
                $.ajax({
                    type: "POST",
                    url:  "/api/room/standup",
                    data: {
                        room: room,
                        user: user,
                        seat: seat
                    },
                    success: function(data) {
                    }
                });
            }
        },
        ready: function () {
            $.getJSON('/api/room/'+this.room+'/seats', function(data) {
                this.seats = data;
            }.bind(this));

            socket.on('game-channel:App\\Events\\SitDown', function(data) {
                console.log(data);
                this.seats['seat'+data.seat] = data.user;
            }.bind(this));

            socket.on('game-channel:App\\Events\\StandUp', function(data) {
                console.log(data);
                if (data.result === true) {
                    this.seats['seat'+data.seat] = null;
                } 
            }.bind(this));
        }
    });

</script>
@endsection
