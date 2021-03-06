@unless($user->roles->isEmpty())
    <li>Funkcija: <strong>{{ $user->roles->first()->display_name }}</strong></li>
    @unless($user->groups->isEmpty())
        <li>Skupine:
            <ul>
                @foreach($user->groups as $group)
                    <li><a href="{!! action('GroupsController@show', [$group]) !!}">{{ $group->name }}</a>
                        <br>
                        - Funkcija: {{ $group->roles->first()->name }}
                    </li>
                @endforeach
            </ul></li>
    @endunless
@endunless
@unless($user->permissions->isEmpty())
    <li>Dodatne pravice:
        <ul>
            @foreach($user->permissions as $permission)
                <li>{{ $permission->display_name }}</li>
            @endforeach
        </ul></li>
@endunless