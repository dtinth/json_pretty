json_pretty
===========

A JSON pretty-printer for PHP. Usage:

    echo json_pretty(json_encode($data));

The output style of this function is highly configurable. There are 2 built-in styles included. See the source.


Example
-------

An example of prettyprinted JSON:

    { "updated": 1304434891,
      "crews": [
        { "rank": 1,
          "previousRanks": [ 11, 323 ],
          "emblemPlate": { "id": "816833289" },
          "emblemPattern": { "id": "1353236320" },
          "name": "BBG-RM3",
          "points": 1517,
          "course": {
            "stages": [
              { "pattern": "cosmicfantastic_3",
                "effects": { "fade": "-", "line": "-", "scroll": "-" } },
              { "pattern": "supersonicrmx_3",
                "effects": { "fade": "-", "line": "-", "scroll": "-" } },
              { "pattern": "someday_3",
                "effects": { "fade": "-", "line": "-", "scroll": "-" } } ],
            "producer": "BOAT",
            "plays": 21,
            "wins": 17 } } ],
      "round": 19 }

Looks nice don't you think?