create table euromillions_draws
(
	id int unsigned auto_increment
		primary key,
	lottery_id int unsigned null,
	draw_date date not null,
	result_regular_number_one int null,
	result_regular_number_two int null,
	result_regular_number_three int null,
	result_regular_number_four int null,
	result_regular_number_five int null,
	result_lucky_number_one int null,
	result_lucky_number_two int null,
	jackpot_amount bigint null,
	jackpot_currency_name varchar(255) null,
	constraint UNIQ_79652A5B38C98BF
		unique (draw_date));



