<?php

namespace App\Machines;

use App\Models\Topic;
use App\Http\Resources\TopicSimple;

class FocusMachine extends BaseMachine
{
    public $action = 'focus';

    public function make(Topic $topic)
    {
        $params = [
            'topic_id' => $topic->id,
        ];

        $this->fetch($params, $topic->id);
    }

    public function generate(array $params)
    {
        $topic = auth()->guard('api')->user()->topics()->where('topic_id', $params['topic_id'])->first();

        return [
            'topic' => new TopicSimple($topic),
        ];
    }

    public function remove(Topic $topic)
    {
        $this->detch($topic->id);
    }
}
