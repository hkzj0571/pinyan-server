<?php

function respond($status, $respond)
{
    return response()->json(['status' => $status, is_string($respond) ? 'message' : 'data' => $respond]);
}

function succeed($respond = 'Request success!')
{
    return respond(true, $respond);
}

function failed($respond = 'Request failed!')
{
    return respond(false, $respond);
}

function rules($rule_name)
{
    return config("rules.{$rule_name}");
}

function hommization($date)
{
    if (\Carbon\Carbon::now() > \Carbon\Carbon::parse($date)->addDays(30)) {
        return \Carbon\Carbon::parse($date)->toDateTimeString();
    }
    return \Carbon\Carbon::parse($date)->diffForHumans();
}

function api_version()
{
    return str_finish(config('api.version'), '/');
}