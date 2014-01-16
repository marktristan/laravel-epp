<?php

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class DomainCmd extends Command {

	/**
	 * The console command name.
	 *
	 * @var string
	 */
	protected $name = 'epp:domain';

	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = 'Command description.';

	/**
	 * Create a new command instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
	}

	/**
	 * Execute the console command.
	 *
	 * @return mixed
	 */
	public function fire()
	{
		$registrar = $this->ask("Registrar handle: ");
		$password = $this->secret("Registrar password: ");

		$this->comment("\n====== Select Method ======");
		$this->info("check, info, create, update");
		$this->comment("===========================");
		$method = $this->ask("Method: ");

		$domain = $this->ask("\nDomain handle: ");

		if (trim($registrar) != '' && trim($password) != '')
		{
			EppCmd::connect();
			EppCmd::login($registrar, $password);

			$data = new stdClass();
			$data->handle = $domain;

			switch ($method)
			{
				case 'check':
				{
					$response = EppCmd::$epp->request(Domain::check($data));
					$this->comment("\n========= Result ==========");
					$this->info(print_r(EppCmd::result($response, 'domainCheck'), true));
					$this->comment("===========================");
				} break;

				case 'info':
				{
					$response = EppCmd::$epp->request(Domain::info($data));
					$this->comment("\n========= Result ==========");
					$this->info(print_r(EppCmd::result($response, 'domainInfo'), true));
					$this->comment("===========================");
				} break;

				default: $this->error('Please check parameters.'); break;
			}
		}
		else
		{
			$this->error('Please check parameters.');
		}
	}

	/**
	 * Get the console command arguments.
	 *
	 * @return array
	 */
	protected function getArguments()
	{
		return array(
			//array('example', InputArgument::REQUIRED, 'An example argument.'),
			//array('method', InputArgument::REQUIRED, 'EPP domain method: check, info, create, update.'),
			//array('handle', InputArgument::REQUIRED, 'Domain handle/name.'),
		);
	}

	/**
	 * Get the console command options.
	 *
	 * @return array
	 */
	protected function getOptions()
	{
		return array(
			//array('example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null),
		);
	}

}
