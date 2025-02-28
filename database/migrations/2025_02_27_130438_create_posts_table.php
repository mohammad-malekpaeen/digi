<?php

use App\Enum\FieldEnum;
use App\Models\Category;
use App\Models\User;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Category::class, FieldEnum::categoryId->value)->constrained()->nullOnDelete();
            $table->foreignIdFor(User::class, FieldEnum::userId->value)->constrained()->nullOnDelete();
            $table->string(FieldEnum::title->value);
            $table->string(FieldEnum::slug->value)->unique();
            $table->longText(FieldEnum::body->value)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
