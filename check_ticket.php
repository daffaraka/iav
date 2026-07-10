<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$ticket = DB::table('tikets')->where('id', 268)->first();
if (!$ticket) {
    echo json_encode(['error' => 'Ticket not found']);
    exit;
}

$admin = $ticket->admin_humas ? DB::table('users')->where('id', $ticket->admin_humas)->first() : null;
$pic = $ticket->pic_id ? DB::table('users')->where('id', $ticket->pic_id)->first() : null;

echo json_encode([
    'ticket_id' => 268,
    'admin_humas_id' => $ticket->admin_humas,
    'admin_humas_name' => $admin ? $admin->name : null,
    'pic_id' => $ticket->pic_id,
    'pic_name' => $pic ? $pic->name : null,
], JSON_PRETTY_PRINT);
