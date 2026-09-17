<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('categories', function (Blueprint $t) { $t->id(); $t->string('name'); $t->string('slug')->unique(); $t->text('description')->nullable(); $t->timestamps(); });
        Schema::create('products', function (Blueprint $t) { $t->id(); $t->foreignId('category_id')->constrained()->restrictOnDelete(); $t->string('code')->unique(); $t->string('name'); $t->string('slug')->unique(); $t->text('description')->nullable(); $t->decimal('price',12,2); $t->unsignedInteger('stock')->default(0); $t->string('duration')->nullable(); $t->string('image')->nullable(); $t->boolean('is_active')->default(true); $t->timestamps(); $t->softDeletes(); });
        Schema::table('users', fn (Blueprint $t) => $t->string('phone',20)->nullable()->after('email'));
        Schema::create('transactions', function (Blueprint $t) { $t->id(); $t->foreignId('user_id')->constrained()->restrictOnDelete(); $t->string('transaction_code')->unique(); $t->string('visitor_name'); $t->date('visit_date'); $t->text('notes')->nullable(); $t->decimal('total_price',12,2); $t->string('status')->default('pending'); $t->text('cancelled_reason')->nullable(); $t->timestamps(); });
        Schema::create('transaction_items', function (Blueprint $t) { $t->id(); $t->foreignId('transaction_id')->constrained()->cascadeOnDelete(); $t->foreignId('product_id')->constrained()->restrictOnDelete(); $t->unsignedInteger('quantity')->default(1); $t->decimal('price',12,2); $t->decimal('subtotal',12,2); $t->timestamps(); });
        Schema::create('cart_items', function (Blueprint $t) { $t->id(); $t->foreignId('user_id')->constrained()->cascadeOnDelete(); $t->foreignId('product_id')->constrained()->cascadeOnDelete(); $t->unsignedInteger('quantity')->default(1); $t->timestamps(); $t->unique(['user_id','product_id']); });
        Schema::create('association_rules', function (Blueprint $t) { $t->id(); $t->foreignId('antecedent_product_id')->constrained('products')->cascadeOnDelete(); $t->foreignId('consequent_product_id')->constrained('products')->cascadeOnDelete(); $t->decimal('support',8,4); $t->decimal('confidence',8,4); $t->decimal('lift_ratio',10,4); $t->boolean('is_active')->default(true); $t->timestamps(); $t->index(['antecedent_product_id','is_active']); });
        Schema::create('apriori_configs', function (Blueprint $t) { $t->id(); $t->decimal('min_support',4,2)->default(.10); $t->decimal('min_confidence',4,2)->default(.60); $t->boolean('schedule_enabled')->default(true); $t->unsignedInteger('schedule_interval_hours')->default(24); $t->timestamp('last_calculated_at')->nullable(); $t->unsignedInteger('total_rules_last_run')->default(0); $t->timestamps(); });
        Schema::create('apriori_logs', function (Blueprint $t) { $t->id(); $t->string('triggered_by'); $t->foreignId('triggered_by_user_id')->nullable()->constrained('users')->nullOnDelete(); $t->unsignedInteger('total_transactions')->default(0); $t->unsignedInteger('total_frequent_itemsets')->default(0); $t->unsignedInteger('total_rules_generated')->default(0); $t->unsignedInteger('execution_time_ms')->default(0); $t->string('status')->default('success'); $t->text('error_message')->nullable(); $t->timestamps(); });
    }
    public function down(): void { Schema::dropIfExists('apriori_logs'); Schema::dropIfExists('apriori_configs'); Schema::dropIfExists('association_rules'); Schema::dropIfExists('cart_items'); Schema::dropIfExists('transaction_items'); Schema::dropIfExists('transactions'); Schema::dropIfExists('products'); Schema::dropIfExists('categories'); Schema::table('users', fn(Blueprint $t) => $t->dropColumn('phone')); }
};
