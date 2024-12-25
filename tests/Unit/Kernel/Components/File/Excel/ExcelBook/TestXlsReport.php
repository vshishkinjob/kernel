<?php

declare(strict_types=1);

namespace Unit\Kernel\Components\File\Excel\ExcelBook;

use Kernel\Components\File\Excel\ExcelBook\BaseXlsReport;
use Kernel\Components\File\Excel\ExcelBook\config\ExcelConfigurator;

class TestXlsReport extends BaseXlsReport
{
	public function __construct(
		private readonly TestReportDto $data,
        private readonly ExcelConfigurator $excelConfigurator
	)
	{
		parent::__construct($this->excelConfigurator);
	}

	public function templatePath(): string
	{
		return __DIR__ . '/test-report.xls';
	}

	public function filename(): string
	{
		return "report_name.xls";
	}

	protected function additionalData(): array
	{
		return [
			'additionalData' => 'SOME_ADDITIONAL_DATA'
		];
	}

	protected function tableData(): array
	{
		$id = 0;

		return array_map(function (array $item) use (&$id) {
            /** @var  array{id: int, data:string} $item */
			$data['#'] = ++$id;
			$data['id'] = $item['id'];
            $data['data'] = $item['data'];
			return $data;
		}, $this->data->getItems());
	}

	protected function tableFields(): array
	{
		return [
			'#',
			'id',
			'data',
		];
	}
}
