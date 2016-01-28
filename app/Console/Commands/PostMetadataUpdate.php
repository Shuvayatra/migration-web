<?php namespace App\Console\Commands;

use App\Nrna\Models\Post;
use Illuminate\Console\Command;

/**
 * Class PostMetadataUpdate
 * @package App\Console\Commands
 */
class PostMetadataUpdate extends Command
{

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'metadata:post';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update Post Metadata.';


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
        $posts = Post::all();
        foreach ($posts as $post) {
            $this->updateMetadata($post);
        }

    }

    /**
     * Update Post Metadata
     *
     * @param Post $post
     */
    public function updateMetadata(Post $post)
    {
        $metadata       = json_decode(json_encode($post->metadata), true);
        $post->metadata = $this->applyRules($metadata);

        $post->save();

        $this->info(sprintf('Post ID %s : UPDATED', $post->id));
    }

    /**
     * Apply rules to metadata update
     *
     * @param array $metadata
     * @return array
     */
    protected function applyRules(array $metadata)
    {
        $this->addAudioThumbnail($metadata);

        return $metadata;
    }

    /**
     * add thumbnail to metadata
     * @param $metadata
     */
    protected function addAudioThumbnail(&$metadata)
    {
        $metadata['data']['thumbnail'] = '';
    }
}
