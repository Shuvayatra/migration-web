<?php namespace App\Console\Commands;

use App\Nrna\Models\Question;
use Illuminate\Console\Command;

/**
 * Class QuestionMetadataUpdate
 * @package App\Console\Commands
 */
class QuestionMetadataUpdate extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'nrna:question_update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Question Metadata.';


    /**
     * Create a new command instance.
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     */
    public function fire()
    {
        $questions = Question::all();
        foreach ($questions as $question) {
            $this->updateMetadata($question);
        }

    }

    /**
     * Update Question Metadata
     *
     * @param Question $question
     */
    public function updateMetadata(Question $question)
    {
        $metadata       = json_decode(json_encode($question->metadata), true);
        $question->metadata = $this->applyRules($metadata);

        $question->save();

        $this->info(sprintf('Question ID %s : UPDATED', $question->id));
    }

    /**
     * Apply rules to metadata update
     *
     * @param array $metadata
     * @return array
     */
    protected function applyRules(array $metadata)
    {
        $this->addAnswer($metadata);

        return $metadata;
    }

    /**
     * add thumbnail to metadata
     * @param $metadata
     */
    protected function addAnswer(&$metadata)
    {
        $metadata['answer'] = '';
    }

}
