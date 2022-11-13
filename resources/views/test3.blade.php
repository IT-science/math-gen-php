<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

<table class="table table-bordered table-striped">
    <thead>
        <tr>
            <td><strong>{{--i&darr;, j&rarr;--}}</strong></td>
            @foreach ($matrix[0] as $j => $interval)
                <th>j{{ $j }}</th>
            @endforeach
        </tr>
    </thead>

    <tbody>
        @foreach ($matrix as $i => $row)
            <tr>
                <th>i{{ $i }}</th>
                @foreach ($row as $j => $interval)
                    <td <?= ($i < $iStart || $j < $jStart) ? 'class="table-success"' : '' ?>>
{{--                        {{ $interval->left() }}--}}
                        <u class="{{ $results[$i][$j] > 0 ? 'badge bg-warning' : '' }}">d={{ $results[$i][$j] }}</u>
                        <br/>
                        a={{ $alphas[$i][$j] }}
                        <br/>
                        v={{ $interval->left() }}
                        <br/>
                        z={{ $z['nums'][$i][$j] }}
                        <br>
                        [{{ $z['left'][$i][$j] }}, {{ $z['right'][$i][$j] }}]

                        <?php if ($maxDelta && $deltas[$i][$j] === $maxDelta) {
                            $class = 'bg-danger';
                        } elseif ($deltas[$i][$j]) {
                            $class = 'bg-primary';
                        } else {
                            $class = 'bg-secondary';
                        } ?>
                        <span class="badge rounded-pill {{ $class }}">{{ round($deltas[$i][$j], 2) }}</span>
{{--                        {{ round($deltas[$i][$j], 2) }}--}}
                    </td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>
