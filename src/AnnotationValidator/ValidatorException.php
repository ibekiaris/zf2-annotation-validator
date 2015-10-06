<?php
namespace AnnotationValidator;

/**
 * Validator Exception file
 * give us the opportunity
 * to create validation error messages
 * according our will
 *
 * @category   CategoryName
 * @package    annotation_validator_package
 * @author     Ioannis Bekiaris <bekiarisgiannis85@gmail.com>
 * @copyright  2015 - 2016 Ioannis Bekiaris
 */
class ValidatorException extends \Exception
{
    /**
     * @var string
     */
    protected $shortMessage;

    /**
     * @var string
     */
    protected $longMessage;

    /**
     * @var array
     */
    protected $validationErrors;

    public function __construct($validationErrors, $message = "Invalid Data", $code = 0, \Exception $previous = null)
    {
        $this->validationErrors = $validationErrors;
        $this->buildShortLongMessages();
        parent::__construct($message, $code, $previous);
    }

    public function getShortMessage()
    {
        return $this->shortMessage;
    }

    public function getLongMessage()
    {
        return $this->longMessage;
    }

    protected function buildShortLongMessages()
    {
        $validationErrors = $this->validationErrors;

        $shortMessage = '';
        $longMessage  = '';

        foreach ($validationErrors as $fieldName => $validationError) {
            foreach ($validationError as $errorMessages) {
                $shortMessage .= $fieldName . ', ';
                $longMessage  .= $fieldName ;
                foreach ($errorMessages['error_messages'] as $errorMessage) {
                    $longMessage .= ' - ' . $errorMessage;
                }

                $longMessage .= ' ';
            }
        }

        // TODO translate "are Invalid"
        $shortMessage .= ' are Invalid!';

        $this->shortMessage = $shortMessage;
        $this->longMessage  = $longMessage;
    }
}
