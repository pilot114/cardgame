
var conn = new WebSocket('ws://localhost:8080');
conn.onopen = function(e) {
  console.log("Connection established!");

  var deckA = [
    '1','2','3','4','5','6','13','14','18'
  ];
  var deckB = [
    '7','8','9','10','11','12','15','16','17'
  ];
  var createGameMessage = JSON.stringify({'Mage':deckA, 'Hunter':deckB});

  conn.send( createGameMessage );

  conn.send( JSON.stringify({hand:1, position:1}) );
  conn.send( JSON.stringify({end: true}) );
};

conn.onmessage = function(e) {
  console.log( JSON.parse(e.data) );
};
