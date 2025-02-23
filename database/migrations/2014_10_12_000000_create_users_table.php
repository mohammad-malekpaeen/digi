<?php

use App\Enum\FieldEnum;
use App\Enum\UserTypeEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    /**
     * Run the migrations.
     */
    public function up(): void {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string(FieldEnum::email->value)->unique();
            $table->string(FieldEnum::mobileNumber->value)->nullable()->unique();
            $table->string(FieldEnum::name->value)->nullable();
            $table->string(FieldEnum::family->value)->nullable();
            $table->unsignedTinyInteger(FieldEnum::sex->value)->nullable();
            $table->string(FieldEnum::nationalCode->value)->nullable();
            $table->string(FieldEnum::economicCode->value)->nullable();
            $table->dateTime(FieldEnum::birthday->value)->nullable();
            $table->unsignedInteger(FieldEnum::type->value)->default(UserTypeEnum::REAL->value);
            $table->integer(FieldEnum::financeScore->value)->default(0);
            $table->boolean(FieldEnum::canSell->value)->default(false);
            $table->boolean(FieldEnum::canBuy->value)->default(true);
            $table->timestamp(FieldEnum::nationalVerifiedAt->value)->nullable();
            $table->timestamp(FieldEnum::emailVerifiedAt->value)->nullable();
            $table->dateTime(FieldEnum::verifiedAt->value)->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->rememberToken();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void {
        Schema::dropIfExists('users');
    }
};
