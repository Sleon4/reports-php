<?php

namespace App\Console\Framework\New;

use App\Traits\Framework\ClassPath;
use App\Traits\Framework\ConsoleOutput;
use LionFiles\Store;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class EnumsCommand extends Command {

    use ClassPath, ConsoleOutput;

	protected static $defaultName = "new:enum";

	protected function initialize(InputInterface $input, OutputInterface $output) {

	}

	protected function interact(InputInterface $input, OutputInterface $output) {

	}

	protected function configure() {
		$this
            ->setDescription("Command required for creating new Enums")
            ->addArgument('enum', InputArgument::OPTIONAL, 'Enum name', "ExampleEnum");
	}

	protected function execute(InputInterface $input, OutputInterface $output) {
		$enum = $input->getArgument('enum');
        $list = $this->export("app/Enums/", $enum);
        $url_folder = lcfirst(str_replace("\\", "/", $list['namespace']));
        Store::folder($url_folder);

        $this->create($url_folder, $list['class']);
        $this->add(str->of("<?php")->ln()->ln()->get());
        $this->add(str->of("namespace ")->concat($list['namespace'])->concat(";")->ln()->ln()->get());

        $this->add(
            str->of("enum ")
                ->concat($list['class'])
                ->concat(": string {")->ln()->ln()->lt()
                ->concat("case EXAMPLE = 'example';")->ln()->ln()->lt()
                ->concat("public static function values(): array {")->ln()->lt()->lt()
                ->concat('return array_map(fn($value) => $value->value, self::cases());')->ln()->lt()
                ->concat("}")->ln()->ln()
                ->concat("}")
                ->get()
        );

        $this->force();
        $this->close();

        $output->writeln($this->warningOutput("\t>>  ENUM: {$enum}"));
        $output->writeln($this->successOutput("\t>>  ENUM: The '{$list['namespace']}\\{$list['class']}' enum has been generated"));
        return Command::SUCCESS;
	}

}
