<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <td><strong>{{--i&darr;, j&rarr;--}}</strong></td>
            <th></th>
        </tr>
    </thead>

    <tbody>
        @foreach ($matrix as $i => $interval)
            <tr>
                <th>i{{ $i }}</th>
                <td <?= ($i < $iStart) ? 'class="table-success"' : '' ?>>
                    {{ $interval }}

                    <?php if ($maxDelta && $deltas[$i] === $maxDelta) {
                        $class = 'bg-danger';
                    } elseif ($deltas[$i]) {
                        $class = 'bg-primary';
                    } else {
                        $class = 'bg-secondary';
                    } ?>
                    <span class="badge rounded-pill {{ $class }}">{{ round($deltas[$i], 6) }}</span>
{{--                        {{ round($deltas[$i][$j], 2) }}--}}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
