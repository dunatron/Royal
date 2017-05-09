<?php
use Heyday\SilverStripe\WkHtml;
class PDFController extends Controller {

	private static $allowed_actions = array(
		'index'
	);

	public function index(SS_HTTPRequest $request)
	{


		//$Content = $this->Content($request->param('ID'));

		$Page = Page::get()->byID($request->param('ID'));

		// $arrayData = new ArrayData(array(
		//  	'Content' => $Content
		// ));

		//$pathtoWKHTMLTOPDF = $_SERVER['DOCUMENT_ROOT'].'/vendor/h4cc/wkhtmltopdf-amd64/bin/wkhtmltopdf-amd64';

		$pathtoWKHTMLTOPDF = '/usr/local/bin/wkhtmltopdf.sh';

		//die($pathtoWKHTMLTOPDF);

		// $generator = new Heyday\SilverStripe\WkHtml\Generator(
		// 	new \Knp\Snappy\Pdf($pathtoWKHTMLTOPDF),
		// 	//new \Heyday\SilverStripe\WkHtml\Input\Template('Page',$arrayData),
		// 	new \Heyday\SilverStripe\WkHtml\Input\Url($Page->Link()),
		// 	new \Heyday\SilverStripe\WkHtml\Output\Browser($Page->Title.'.pdf','application/pdf')
		// );
		// return $generator->process();


		$generator = new WkHtml\Generator(
		    new \Knp\Snappy\Pdf($pathtoWKHTMLTOPDF),
		    new WkHtml\Input\Url($Page->Link()),
		    new WkHtml\Output\Browser('test.pdf', 'application/pdf')
		);
		return $generator->process();


	}

	public function Content($ID)
	{

		$Document = Page::get()->byID($ID);
		$tocclass = 'open';
		$TOC = $this->TOC($ID, null, $Document->NoNumbering, $tocclass);
		$Content = $this->childContent($ID, null, $Document->NoNumbering);
		return '<h3 id="toctitle" class="'.$tocclass.'">Table of Contents</h3>'.$TOC.$Content;
	}

	private function childContent($ParentID=null, $pcount, $numbering)
	{
		$Content = '';
		if($ParentID)
		{	
			$count = 1;
			$Parts = Page::get()->filter(array('ParentID'=>$ParentID));
			foreach($Parts as $Part)
			{
				$number = null;
				if($numbering == 0){
					if($pcount){
						$number = $pcount.'.'.$count.'. ';
					}
					else
					{
						$number = $count.'. ';
					}
				}
				$Type = $Part->getClassName();
				if($Type == 'DocumentParagraph')
				{
					$Content .= '<h1 class="documentpara" id="'.$Part->ID.'">'.$number.$Part->Title.'</h1>';
					$Content .=  $Part->Content;
				}
				else
				{
					$Content .= '<h1 class="documentsec" id="'.$Part->ID.'">'.$number.$Part->Title.'</h1>';
					$Content .= $this->childContent($Part->ID, $count, $numbering);
				}
				$count++;
			}

		}
		return $Content;
	}

	private function TOC($ParentID=null, $pcount, $numbering, $tocclass=null)
	{
		$Content = '<ul class="royaltoc '.$tocclass.'">';
		if($ParentID)
		{	
			$count = 1;
			$Parts = Page::get()->filter(array('ParentID'=>$ParentID));
			foreach($Parts as $Part)
			{
				$number = null;
				if($numbering == 0){
					if($pcount){
						$number = $pcount.'.'.$count.'. ';
					}
					else
					{
						$number = $count.'. ';
					}
				}
				$Type = $Part->getClassName();
				if($Type == 'DocumentParagraph')
				{
					$Content .= '<li><a href="#'.$Part->ID.'">'.$number.$Part->Title.'</a></li>';
					//$Content .=  $Part->Content;
				}
				else
				{
					$Content .= '<li><a href="#'.$Part->ID.'">'.$number.$Part->Title.'</a>';
					$Content .= $this->TOC($Part->ID, $count, $numbering);
					$Content .= '</li>';
				}
				$count++;
			}

		}
		$Content .= '</ul>';
		return $Content;
	}


	// private function CleanAnchor($link)
	// {
	// 	return trim(str_replace("/","-",$link),'-');
	// }

	// private function sectionPDF($SectionID)
	// {
	// 	// snip HTML for section
	// 	$Section = Section::get()->byId($SectionID);
	// 	$Chapter = Chapter::get()->byId($Section->ParentID);
	// 		$Output = '


	// 		<h2 class="section" sectionid="'.$Section->ID.'"><a name="'.$this->CleanAnchor($Section->Link()).'" />'.$Chapter->Sort.'.'.$Section->Sort.'. '.$Section->Title.'</h2>';
			
	// 		$SubSections = SubSection::get()->filter(array('ParentID'=>$Section->ID));
	// 		foreach($SubSections as $SubSection)
	// 		{
	// 			$Output .= '<h3 class="subsection"><a name="'.$this->CleanAnchor($SubSection->Link()).'" />'.$SubSection->Title.'</h3>';

	// 			if($SubSection->Type == 'Rationale and Controls')
	// 			{
	// 				$Blocks = Block::get()->filter(array('ParentID'=>$SubSection->ID));
	// 				if(count($Blocks) == 0)
	// 				{

	// 					$Paragraphs = Paragraph::get()->filter(array('ParentID'=>$SubSection->ID));
	// 					foreach($Paragraphs as $Paragraph)
	// 					{
	// 						if($Paragraph->Type == 'Control')
	// 						{
	// 							$Classifications = '';
	// 							foreach($Paragraph->Classifications() as $Classification)
	// 							{
	// 								if($Classification->Classification == 'All Classifications')
	// 								{
	// 									$Classifications = 'All Classifications';
	// 									break;
	// 								}
	// 								else
	// 								{
	// 									$Classifications .= $Classification->Classification.', ';
	// 								}
	// 							}
	// 							$Classifications = rtrim($Classifications,', ');
	// 							$Output .= '
	// 									<h5 class="RandCHead">
	// 										<span>
	// 											<a name="'.$this->CleanAnchor($Paragraph->Link()).'" />'.$Paragraph->Title.'
	// 										</span>'.$Paragraph->Type.':&nbsp; 
	// 									</h5>
	// 									<span class="RandCSpan"> System Classification(s): '.$Classifications.'; Compliance: '.strtoupper($Paragraph->Compliance()->Compliance).'</span>
	// 									<div class="RandCPara">'.$Paragraph->Content.'</div>';
	// 						}
	// 						else
	// 						{
	// 							$Output .= '
	// 								<h5 class="RandCHead">
	// 									<span><a name="'.$this->CleanAnchor($Paragraph->Link()).'" />'.$Paragraph->Title.'</span>
	// 									'.$Paragraph->Type.'
	// 								</h5>
	// 								<div class="RandCPara">'.$Paragraph->Content.'</div>';
	// 						}
	// 					}
	// 				}
	// 				else
	// 				{
	// 					foreach($Blocks as $Block)
	// 					{
	// 						$Output .= '<h4 class="blockRandC"><span><a name="'.$this->CleanAnchor($Block->Link()).'" />'.$Block->Number.'</span> '.$Block->Title.'</h4>';

	// 						$Paragraphs = Paragraph::get()->filter(array('ParentID'=>$Block->ID));
	// 						foreach($Paragraphs as $Paragraph)
	// 						{
	// 							if($Paragraph->Type == 'Control')
	// 							{
	// 								$Classifications = '';
	// 								foreach($Paragraph->Classifications() as $Classification)
	// 								{
	// 									if($Classification->Classification == 'All Classifications')
	// 									{
	// 										$Classifications = 'All Classifications';
	// 										break;
	// 									}
	// 									else
	// 									{
	// 										$Classifications .= $Classification->Classification.', ';
	// 									}
	// 								}
	// 								$Classifications = rtrim($Classifications,', ');
	// 								$Output .= '
	// 									<h5 class="RandCHead">
	// 										<span>
	// 											<a name="'.$this->CleanAnchor($Paragraph->Link()).'" />'.$Paragraph->Title.'
	// 										</span>'.$Paragraph->Type.':&nbsp;
	// 									</h5>
	// 									<span class="RandCSpan"> System Classification(s): '.$Classifications.'; Compliance: '.strtoupper($Paragraph->Compliance()->Compliance).'</span>
	// 									<div class="RandCPara">'.$Paragraph->Content.'</div>';
	// 							}
	// 							else
	// 							{
	// 								$Output .= '
	// 								<h5 class="RandCHead">
	// 									<span><a name="'.$this->CleanAnchor($Paragraph->Link()).'" />'.$Paragraph->Title.'</span>
	// 									'.$Paragraph->Type.'
	// 								</h5>
	// 								<div class="RandCPara">'.$Paragraph->Content.'</div>';
	// 							}

	// 						}
	// 					}
	// 				}
	// 			}
	// 			else
	// 			{
	// 				$Blocks = Block::get()->filter(array('ParentID'=>$SubSection->ID));
	// 				if(count($Blocks) == 0)
	// 				{

	// 					$Paragraphs = Paragraph::get()->filter(array('ParentID'=>$SubSection->ID));
	// 					foreach($Paragraphs as $Paragraph)
	// 					{
	// 						$Output .= '
	// 						<div class="subsectionPara">
	// 							<span><a name="'.$this->CleanAnchor($Paragraph->Link()).'" />'.$Paragraph->Title.'</span>
	// 							'.$Paragraph->Content.'
	// 						</div>';

	// 					}
	// 				}
	// 				else
	// 				{
	// 					foreach($Blocks as $Block)
	// 					{
	// 						$Output .= '<h4 class="subBlock"><a name="'.$this->CleanAnchor($Block->Link()).'" />'.$Block->Title.'</h4>';

	// 						$Paragraphs = Paragraph::get()->filter(array('ParentID'=>$Block->ID));
	// 						foreach($Paragraphs as $Paragraph)
	// 						{
	// 							$Output .= '
	// 							<div class="blockPara">
	// 								<span><a name="'.$this->CleanAnchor($Paragraph->Link()).'" />'.$Paragraph->Title.'</span>
	// 								'.$Paragraph->Content.'
	// 							</div>';

	// 						}
	// 					}
	// 				}
	// 			}
	// 		}
	// 	//}


	// 	return $Output;
	// 	// include CSS

	// 	// generate PDF
	// }

}