<table>
    <thead>
    <tr>
        <th>
            <h1>
                @if (! empty($greeting))
                    {{ $greeting }}
                @else
                    @if ($level === 'error')
                        @lang('Whoops!')
                    @else
                        @lang('Hello!')
                    @endif
                @endif
            </h1>
        </th>
    </tr>
    </thead>
    <tbody style="text-align: center;">
    @foreach ($introLines as $line)
        <tr>
            <td>
                <h2>{{ $line }}</h2>
            </td>
        </tr>
    @endforeach
    <tr>
        <td style="padding: 12px 0 28px 0;">
            <a
                href="{{$actionUrl}}"
                style=" background: #3C64B1;
                        border-color: #3C64B1;
                        border-radius: 12px;
                        border-style: solid;
                        border-width: 14px 28px 14px 28px;
                        font-style: normal;
                        font-weight: 700;
                        font-size: 18px;
                        line-height: 24px;
                        text-align: center;
                        text-decoration: none;
                        color: #FFFFFF;"
            >{{ $actionText }}</a>
        </td>
    </tr>
    <tr>
        <td>
            @lang(
                "If you're having trouble clicking the \":actionText\" button, copy and paste the URL below\n".
                'into your web browser:',
                [
                    'actionText' => $actionText,
                ]
            )
        </td>
    </tr>
    <tr>
        <td>
            <span class="break-all">{{ $actionUrl }}</span>
        </td>
    </tr>
    </tbody>
</table>




