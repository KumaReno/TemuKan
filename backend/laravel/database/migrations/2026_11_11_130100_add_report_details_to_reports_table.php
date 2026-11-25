<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->foreignId('category_id')
                ->after('id')
                ->constrained()
                ->restrictOnDelete();
            $table->string('name')->after('category_id');
            $table->string('status', 20)->index()->after('name');
            $table->text('description')->after('status');
            $table->string('location')->after('description');
            $table->date('event_date')->index()->after('location');
            $table->string('reporter_name')->after('event_date');
            $table->string('contact')->nullable()->after('reporter_name');
            $table->string('image_path')->nullable()->after('contact');
        });
    }

    public function down(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropIndex(['status']);
            $table->dropIndex(['event_date']);
            $table->dropColumn([
                'category_id',
                'name',
                'status',
                'description',
                'location',
                'event_date',
                'reporter_name',
                'contact',
                'image_path',
            ]);
        });
    }
};
