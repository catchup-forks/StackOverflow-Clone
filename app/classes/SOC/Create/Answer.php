<?php namespace SOC\Create;

use App\Models\Post;

class Answer implements ICreatable {

    private $data;
    private $user;
    private $post;

    public function __construct($data) {
        $this->data = $data;
        $this->user = array('display_name' => 'Jason', 'id' => 2);
    }

    public function add()
    {
        $this->post                           = new Post;
        $this->post->post_type_id             = 2;
        $this->post->accepted_answer_id       = '';
        $this->post->parent_id                = $this->data['post_id'];
        $this->post->creation_date            = now();
        $this->post->score                    = '0';
        $this->post->view_count               = '0';
        $this->post->body                     = $this->data['answer'];
        $this->post->user_id                  = $this->user['id'];
        $this->post->owner_display_name       = $this->user['display_name'];
        $this->post->last_editor_user_id      = $this->user['id'];
        $this->post->last_editor_display_name = $this->user['display_name'];
        $this->post->last_edit_date           = now();
        $this->post->last_activity_date       = now();
        $this->post->title                    = '';
        $this->post->answer_count             = '0';
        $this->post->comment_count            = '0';
        $this->post->favorite_count           = '0';
        $this->post->closed_date              = null;
        $this->post->community_owned_date     = null;
        $this->post->save();

        return $this->post;
    }

    public function edit()
    {
        # code...
    }

    public function update()
    {
        # code...
    }

    public function delete()
    {
        # code...
    }

}
