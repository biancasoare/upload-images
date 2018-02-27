<?php
/**
 * Created by PhpStorm.
 * User: soarebianca
 * Date: 20/11/2017
 * Time: 22:05
 */

$people = [];
$resultNumber = 170;
for ($i = 0; $i< $resultNumber; $i++) {
    $people[$i] = [
        'name' => "John$i",
        'age' => rand(10, 90),
    ];
}

//$currentPage = isset($_GET['page']) ? $_GET['page'] : 1;
$currentPage = $_GET['page'] ?? 1;
$perPage = $_GET['perPage'] ?? 10;
$showPages = $_GET['showPages'] ?? 5;
$uri = $_SERVER['PHP_SELF'];



echo showResult($people, $currentPage, $perPage, $showPages, $uri);

function showResult($people, $currentPage, $perPage, $showPages, $uri)
{
    $pagination = getPagination($people, $currentPage, $perPage, $showPages, $uri);

    $htmlPagination = showPagination($pagination);

    $table = showTable($people, $currentPage, $perPage);

    return $htmlPagination . $table . $htmlPagination;
}

function showTable($people, $currentPage, $perPage)
{
    $showFrom = ($currentPage - 1) * $perPage;
    $showTo = $showFrom + $perPage;

    $table = "<br><table border='1'>";
    for ($i = $showFrom; $i < $showTo; $i++) {
        if (isset($people[$i]))
            $table .= '<tr>
                       <td>'.$people[$i]['name'].'</td>
                       <td>'.$people[$i]['age'].'</td>
                   </tr>';
    }
    $table .= '</table><br>';

    return $table;
}

function showPagination($pagination) {
    $htmlPagination = '';
    if ($pagination['first'] != null) {
        $htmlPagination .= '<a href="'.$pagination['first']['uri'].'">'.$pagination['first']['label'].'</a> ... &nbsp;';
        $htmlPagination .= '<a href="'.$pagination['previous']['uri'].'">'.$pagination['previous']['label'].'</a>&nbsp;';
    }

    foreach ($pagination['pages'] as $page) {
        $htmlPagination .= '<a href="'.$page['uri'].'">'.$page['label'].'</a>&nbsp;';
    }

    if ($pagination['next'])
        $htmlPagination .= '<a href="'.$pagination['next']['uri'].'">'.$pagination['next']['label'].'</a>...&nbsp;';

    if ($pagination['last'])
        $htmlPagination .= '<a href="'.$pagination['last']['uri'].'">'.$pagination['last']['label'].'<a/>&nbsp;';

    return $htmlPagination;
}

function getPagination($results, $currentPage, $perPage, $showPages, $uri)
{
    $pagination = [
        'first' => null,
        'previous' => null,
        'pages' => [],
        'next' => null,
        'last' => null,
    ];

    if ($currentPage > $showPages) {
        $pagination['first'] = [
            'label' => 1,
            'uri' => $uri . "?perPage=$perPage&page=1",
        ];
    }

    $totalResult = count($results);

    $lastPage = ceil($totalResult/$perPage);

    $pagination['last'] = [
        'label' => $lastPage,
        'uri' => $uri . "?perPage=$perPage&page=$lastPage"
    ];

    $previous = 0;
    if ($currentPage > $showPages ) {
        $previous = ($currentPage%$showPages > 0)
            ? $showPages * floor($currentPage/$showPages)
            : $showPages * floor($currentPage/$showPages) - $showPages;

        $pagination['previous'] = [
            'label' => 'prev', #$previous,
            'uri' => $uri . "?perPage=$perPage&page=$previous",
        ];
    }

    $pagination['pages'] = [];

    for ($x = 1; $x <= $showPages; $x++) {
        $page = $previous + $x;
        if ($lastPage > $page)
            $pagination['pages'][] = [
                'label' => $previous + $x,
                'uri' => $uri . "?perPage=$perPage&page=" . ($previous + $x)
            ];
    }

    $next = $previous + $x;

    if ($next < $lastPage)
        $pagination['next'] = [
            'label' => 'next', #$next,
            'uri' => $uri . "?perPage=$perPage&page=" . $next,
        ];

    return $pagination;
}

