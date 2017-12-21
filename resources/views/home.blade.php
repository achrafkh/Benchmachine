@extends('layouts.master')
@section('content')

@include('layouts.partials.header',['hidden_sidebar' => true])

<div class="listing-wrapper">
    <div class="container">
        <h1 class="page-title">
            My Benchmarks
        </h1>
        <table id="listing-table" class="data-table">
            <thead>
                <tr>
                    <th data-sortable="true">Benchmark Name</th>
                    <th data-sortable="true">Date of creation</th>
                    <th data-sortable="true">Start Date</th>
                    <th data-sortable="true">End Date</th>
                    <th data-sortable="true">Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php for ($i = 1; $i <= 15; $i++) {?>
                    <tr data-index="<?=$i?>">
                        <td class="table-benchmark-name">
                            <a href="">
                                E-Sports
                            </a>
                        </td>
                        <td class="table-digit">17/10/2017</td>
                        <td class="table-digit">17/10/2017</td>
                        <td class="table-digit">17/10/2017</td>
                        <td class="table-digit">
                            <span class="label label-success">Ready</span>
                        </td>
                        <td>
                            <button class="table-delete">
                                <svg class="svg" role="img" title="trash">
                                    <use xlink:href="assets/images/svg-icons.svg#icon-trash"/>
                                </svg>
                            </button>
                        </td>
                    </tr>
                <?php }?>
            </tbody>
        </table>
    </div>
</div>
@endsection
@section('custom-js')
<script type="text/javascript">
$(document).ready(function() {
    var searchIcon = '\
        <svg class="svg" role="img" title="search">\
            <use xlink:href="assets/images/svg-icons.svg#icon-search"/>\
        </svg>'

    $('#listing-table').DataTable({
        paging: true,
        pagingType: "full_numbers",
        ordering: true,
        bLengthChange: false,
        info: false,
        searching: true,
        scrollX: true,
        language: {
            search: searchIcon,
            searchPlaceholder: "Search...",
            paginate: {
                first:      '<i class="icon-angle-double-left"></i>',
                last:       '<i class="icon-angle-double-right"></i>',
                previous:   '<i class="icon-angle-left"></i>',
                next:       '<i class="icon-angle-right"></i>'
            },
        }
    });
} );
</script>


@endsection
