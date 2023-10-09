<small class="text-gray-400">
    @if ($getRecord()->getAliases())

        <table class="table text-left">
            <thead>
            <tr>
                <th style="padding: 0 15px; width: 100px">Alias</th>
                <th style="padding: 0 15px">Status</th>
                <th style="padding: 0 15px">Links</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($getRecord()->getAliases() as $alias)
                <tr>
                    <td style="padding: 0 15px">{{$alias['alias']}}</td>
                    <td style="padding: 0 15px">{{@$alias['status']}}</td>
                    <td style="padding: 0 15px">{{@$alias['count_links']}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>

    @endif
</small>
