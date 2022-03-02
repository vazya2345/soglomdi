<?php
namespace app\components;

use robregonm\pdf\PdfResponseFormatter as PdfResponseFormatterBase;

class PdfResponseFormatter extends PdfResponseFormatterBase;
{
	/**
	 * Formats response HTML in PDF
	 *
	 * @param Response $response
	 */
	protected function formatPdf($response)
	{
		$mpdf = new \mPDF($this->mode,
			$this->format,
			$this->defaultFontSize,
			$this->defaultFont,
			$this->marginLeft,
			$this->marginRight,
			$this->marginTop,
			$this->marginBottom,
			$this->marginHeader,
			$this->marginFooter,
			$this->orientation
		);

		foreach ($this->options as $key => $option) {
			$mpdf->$key = $option;
		}

		if ($this->beforeRender instanceof \Closure) {
			call_user_func($this->beforeRender, $mpdf, $response->data);
		}

		$mpdf->WriteHTML($response->data);
		return $mpdf->Output('', 'S');
	}
}