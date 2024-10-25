<?php

    $jacketID = isset($_POST['id']) ? $_POST['id'] : "";

    // Your MySQL Query and Fetch PHP Code Goes Here

    // After You Fetch Detailed Information, The Shape of That Info Should Be Like Below One

    $detail = [
        "coverImgUrl" => "some image url from cover server", // cover_server.php?cover_id=$a_cover_id&isbn=$isbn&type=$a_type
        "status" => "out", // in or out
        "type" => "dvd", // book or dvd
        "title" => "leSome TitleSome Title", // title of jacket
        "copies" => [
            [
                "position" => "Any Library 1",
                "collections" => [
                    [
                        "Juvenile Non-Fiction",
                        "JNF BI 796.22",
                        "Checked In",
                    ],
                    // More collections
                ]
            ],
            // More copies
        ],
        "summary" => [
            "summary long text 1",
            "summary long text 2"
        ],
        "levels" => [
            "580L", // Lexile Measure
            "3.2", // AR Reading Level
            "MG", // AR Interest Level
            "0.5" // AR Points
        ],
        "details" => [
            "author" => [ // It's by ...
                "Doeden, Matt",
                // Some other authors
            ],
            "belongs" => [  // It's part of the series
                "Blazers. Stars of NASCAR", 
                "Blazers",
                // Some other belongs
            ],
            "length" => "1 volume",
            "relates" => [
                "Earnhardt, Dale, -- Jr. -- Juvenile literature.",
                "Automobile racing drivers -- United States -- Biography -- Juvenile literature.",
                "Stock car drivers -- United States -- Biography -- Juvenile literature.",
                // Some other related things
            ]
        ]
    ];

    $jsonDetail = json_encode($detail);
    echo $jsonDetail;
?>