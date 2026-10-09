<?php

//extracts the trips from the database
function getTravels($conn, $category = null)
{
    if ($category && $category !== 'all') {
        $stmt = $conn->prepare("SELECT * FROM maria_travel WHERE category = ?");
        $stmt->bind_param("s", $category);
        $stmt->execute();
        $result = $stmt->get_result();
    } else {
        $result = $conn->query("SELECT * FROM maria_travel");
    }

    $travels = [];
    while ($row = $result->fetch_assoc()) {
        $travels[] = $row;
    }
    return $travels;
}

function getTravelById($conn, $id)
{
    $stmt = $conn->prepare("SELECT * FROM maria_travel WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function getCategories($conn)
{
    $result = $conn->query("SELECT DISTINCT category FROM maria_travel");
    $categories = [];
    while ($row = $result->fetch_assoc()) {
        $categories[] = $row['category'];
    }
    return $categories;
}