<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Eloquent\Model;

class CreateForeignKeys extends Migration {

	public function up()
	{
		Schema::table('enterprises', function(Blueprint $table) {
			$table->foreign('enterprise_id')->references('user_id')->on('users')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('freelancers', function(Blueprint $table) {
			$table->foreign('freelancer_id')->references('user_id')->on('users')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('projects', function(Blueprint $table) {
			$table->foreign('enterprise_id')->references('enterprise_id')->on('enterprises')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('challenges', function(Blueprint $table) {
			$table->foreign('project_id')->references('project_id')->on('projects')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('devices', function(Blueprint $table) {
			$table->foreign('user_id')->references('user_id')->on('users')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('criterions', function(Blueprint $table) {
			$table->foreign('challenge_id')->references('challenge_id')->on('challenges')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('transactions', function(Blueprint $table) {
			$table->foreign('user_id')->references('user_id')->on('users')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('transactions', function(Blueprint $table) {
			$table->foreign('pack_id')->references('pack_id')->on('packs')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('challenge_freelancer_participation', function(Blueprint $table) {
			$table->foreign('freelancer_id')->references('freelancer_id')->on('freelancers')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('challenge_freelancer_participation', function(Blueprint $table) {
			$table->foreign('challenge_id')->references('challenge_id')->on('challenges')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('freelancer_project_interest', function(Blueprint $table) {
			$table->foreign('freelancer_id')->references('freelancer_id')->on('freelancers')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('freelancer_project_interest', function(Blueprint $table) {
			$table->foreign('project_id')->references('project_id')->on('projects')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('project_skill_required', function(Blueprint $table) {
			$table->foreign('project_id')->references('project_id')->on('projects')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('project_skill_required', function(Blueprint $table) {
			$table->foreign('skill_id')->references('skill_id')->on('skills')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('freelancer_skill', function(Blueprint $table) {
			$table->foreign('skill_id')->references('skill_id')->on('skills')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('freelancer_skill', function(Blueprint $table) {
			$table->foreign('freelancer_id')->references('freelancer_id')->on('freelancers')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('freelancer_criterion_evaluation', function(Blueprint $table) {
			$table->foreign('freelancer_id')->references('freelancer_id')->on('freelancers')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('freelancer_criterion_evaluation', function(Blueprint $table) {
			$table->foreign('criterion_id')->references('criterion_id')->on('criterions')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('user_feature_log', function(Blueprint $table) {
			$table->foreign('user_id')->references('user_id')->on('users')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('user_feature_log', function(Blueprint $table) {
			$table->foreign('feature_id')->references('feature_id')->on('features')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('freelancer_profile_unblocked', function(Blueprint $table) {
			$table->foreign('freelancer_id')->references('freelancer_id')->on('freelancers')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('freelancer_profile_unblocked', function(Blueprint $table) {
			$table->foreign('enterprise_id')->references('enterprise_id')->on('enterprises')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('user_notification', function(Blueprint $table) {
			$table->foreign('notified_id')->references('user_id')->on('users')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('user_notification', function(Blueprint $table) {
			$table->foreign('notifier_id')->references('user_id')->on('users')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('user_notification', function(Blueprint $table) {
			$table->foreign('notification_id')->references('notification_id')->on('notifications')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('challenge_comments', function(Blueprint $table) {
			$table->foreign('challenge_id')->references('challenge_id')->on('challenges')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('challenge_comments', function(Blueprint $table) {
			$table->foreign('user_id')->references('user_id')->on('users')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('messages', function(Blueprint $table) {
			$table->foreign('receiver_id')->references('user_id')->on('users')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('messages', function(Blueprint $table) {
			$table->foreign('sender_id')->references('user_id')->on('users')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		
	}

	public function down()
	{
		Schema::table('enterprises', function(Blueprint $table) {
			$table->dropForeign('enterprises_enterprise_id_foreign');
		});
		Schema::table('freelancers', function(Blueprint $table) {
			$table->dropForeign('freelancers_freelancer_id_foreign');
		});
		Schema::table('projects', function(Blueprint $table) {
			$table->dropForeign('projects_id_enterprise_foreign');
		});
		Schema::table('challenges', function(Blueprint $table) {
			$table->dropForeign('challenges_id_project_foreign');
		});
		Schema::table('devices', function(Blueprint $table) {
			$table->dropForeign('devices_user_id_foreign');
		});
		Schema::table('criterions', function(Blueprint $table) {
			$table->dropForeign('criterions_challenge_id_foreign');
		});
		Schema::table('transactions', function(Blueprint $table) {
			$table->dropForeign('transactions_user_id_foreign');
		});
		Schema::table('transactions', function(Blueprint $table) {
			$table->dropForeign('transactions_pack_id_foreign');
		});
		Schema::table('challenge_freelancer_participation', function(Blueprint $table) {
			$table->dropForeign('challenge_freelancer_participation_id_freelancer_foreign');
		});
		Schema::table('challenge_freelancer_participation', function(Blueprint $table) {
			$table->dropForeign('challenge_freelancer_participation_id_challenge_foreign');
		});
		Schema::table('freelancer_project_interest', function(Blueprint $table) {
			$table->dropForeign('freelancer_project_interest_freelancer_id_foreign');
		});
		Schema::table('freelancer_project_interest', function(Blueprint $table) {
			$table->dropForeign('freelancer_project_interest_id_project_foreign');
		});
		Schema::table('project_skill_required', function(Blueprint $table) {
			$table->dropForeign('project_skill_required_id_project_foreign');
		});
		Schema::table('project_skill_required', function(Blueprint $table) {
			$table->dropForeign('project_skill_required_id_skill_foreign');
		});
		Schema::table('freelancer_skill', function(Blueprint $table) {
			$table->dropForeign('freelancer_skill_skill_id_foreign');
		});
		Schema::table('freelancer_skill', function(Blueprint $table) {
			$table->dropForeign('freelancer_skill_freelancer_id_foreign');
		});
		Schema::table('freelancer_criterion_evaluation', function(Blueprint $table) {
			$table->dropForeign('freelancer_criterion_evaluation_freelancer_id_foreign');
		});
		Schema::table('freelancer_criterion_evaluation', function(Blueprint $table) {
			$table->dropForeign('freelancer_criterion_evaluation_criterion_id_foreign');
		});
		Schema::table('user_feature_log', function(Blueprint $table) {
			$table->dropForeign('user_feature_log_user_id_foreign');
		});
		Schema::table('user_feature_log', function(Blueprint $table) {
			$table->dropForeign('user_feature_log_feature_id_foreign');
		});
		Schema::table('freelancer_profile_unblocked', function(Blueprint $table) {
			$table->dropForeign('freelancer_profile_unblocked_freelancer_id_foreign');
		});
		Schema::table('freelancer_profile_unblocked', function(Blueprint $table) {
			$table->dropForeign('freelancer_profile_unblocked_enterprise_id_foreign');
			
		});
		Schema::table('user_notification', function(Blueprint $table) {
			$table->dropForeign('user_notification_notifier_id_foreign');
		});
		Schema::table('user_notification', function(Blueprint $table) {
			$table->dropForeign('user_notification_notification_id_foreign');
		});
		Schema::table('challenge_comments', function(Blueprint $table) {
			$table->dropForeign('challenge_comments_challenge_id_foreign');
		});
		Schema::table('challenge_comments', function(Blueprint $table) {
			$table->dropForeign('challenge_comments_user_id_foreign');
		});
		Schema::table('messages', function(Blueprint $table) {
			$table->dropForeign('messages_receiver_id_foreign');
		});
		Schema::table('messages', function(Blueprint $table) {
			$table->dropForeign('messages_sender_id_foreign');
		});
		
	 }
}