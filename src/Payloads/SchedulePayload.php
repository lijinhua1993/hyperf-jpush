<?php

namespace Lijinhua\HyperfJpush\Payloads;

use InvalidArgumentException;

class SchedulePayload extends AbstractPayload
{

    /**
     * @param $name
     * @param $push_payload
     * @param $trigger
     * @return array
     * @throws \Lijinhua\HyperfJpush\Exceptions\APIRequestException
     * @throws \Lijinhua\HyperfJpush\Exceptions\ServiceNotAvailable
     */
    public function createSingleSchedule($name, $push_payload, $trigger): array
    {
        if (!is_string($name)) {
            throw new InvalidArgumentException('Invalid schedule name');
        }
        if (!is_array($push_payload)) {
            throw new InvalidArgumentException('Invalid schedule push payload');
        }
        if (!is_array($trigger)) {
            throw new InvalidArgumentException('Invalid schedule trigger');
        }
        $payload            = array();
        $payload['name']    = $name;
        $payload['enabled'] = true;
        $payload['trigger'] = array("single" => $trigger);
        $payload['push']    = $push_payload;

        $url = $this->client->makeURL('schedule');
        return $this->http->post($this->client, $url, $payload);
    }

    /**
     * @param $name
     * @param $push_payload
     * @param $trigger
     * @return array
     * @throws \Lijinhua\HyperfJpush\Exceptions\APIRequestException
     * @throws \Lijinhua\HyperfJpush\Exceptions\ServiceNotAvailable
     */
    public function createPeriodicalSchedule($name, $push_payload, $trigger): array
    {
        if (!is_string($name)) {
            throw new InvalidArgumentException('Invalid schedule name');
        }
        if (!is_array($push_payload)) {
            throw new InvalidArgumentException('Invalid schedule push payload');
        }
        if (!is_array($trigger)) {
            throw new InvalidArgumentException('Invalid schedule trigger');
        }
        $payload            = array();
        $payload['name']    = $name;
        $payload['enabled'] = true;
        $payload['trigger'] = array("periodical" => $trigger);
        $payload['push']    = $push_payload;

        $url = $this->client->makeURL('schedule');
        return $this->http->post($this->client, $url, $payload);
    }

    /**
     * @param $schedule_id
     * @param $name
     * @param $enabled
     * @param $push_payload
     * @param $trigger
     * @return array
     * @throws \Lijinhua\HyperfJpush\Exceptions\APIRequestException
     * @throws \Lijinhua\HyperfJpush\Exceptions\ServiceNotAvailable
     */
    public function updateSingleSchedule(
        $schedule_id,
        $name = null,
        $enabled = null,
        $push_payload = null,
        $trigger = null
    ): array {
        if (!is_string($schedule_id)) {
            throw new InvalidArgumentException('Invalid schedule id');
        }
        $payload = array();
        if (!is_null($name)) {
            if (!is_string($name)) {
                throw new InvalidArgumentException('Invalid schedule name');
            } else {
                $payload['name'] = $name;
            }
        }

        if (!is_null($enabled)) {
            if (!is_bool($enabled)) {
                throw new InvalidArgumentException('Invalid schedule enable');
            } else {
                $payload['enabled'] = $enabled;
            }
        }

        if (!is_null($push_payload)) {
            if (!is_array($push_payload)) {
                throw new InvalidArgumentException('Invalid schedule push payload');
            } else {
                $payload['push'] = $push_payload;
            }
        }

        if (!is_null($trigger)) {
            if (!is_array($trigger)) {
                throw new InvalidArgumentException('Invalid schedule trigger');
            } else {
                $payload['trigger'] = array("single" => $trigger);
            }
        }

        if (count($payload) <= 0) {
            throw new InvalidArgumentException('Invalid schedule, name, enabled, trigger, push can not all be null');
        }

        $url = $this->client->makeURL('schedule') . "/" . $schedule_id;

        return $this->http->put($this->client, $url, $payload);
    }

    /**
     * @param $schedule_id
     * @param $name
     * @param $enabled
     * @param $push_payload
     * @param $trigger
     * @return array
     * @throws \Lijinhua\HyperfJpush\Exceptions\APIRequestException
     * @throws \Lijinhua\HyperfJpush\Exceptions\ServiceNotAvailable
     */
    public function updatePeriodicalSchedule(
        $schedule_id,
        $name = null,
        $enabled = null,
        $push_payload = null,
        $trigger = null
    ): array {
        if (!is_string($schedule_id)) {
            throw new InvalidArgumentException('Invalid schedule id');
        }
        $payload = array();
        if (!is_null($name)) {
            if (!is_string($name)) {
                throw new InvalidArgumentException('Invalid schedule name');
            } else {
                $payload['name'] = $name;
            }
        }

        if (!is_null($enabled)) {
            if (!is_bool($enabled)) {
                throw new InvalidArgumentException('Invalid schedule enable');
            } else {
                $payload['enabled'] = $enabled;
            }
        }

        if (!is_null($push_payload)) {
            if (!is_array($push_payload)) {
                throw new InvalidArgumentException('Invalid schedule push payload');
            } else {
                $payload['push'] = $push_payload;
            }
        }

        if (!is_null($trigger)) {
            if (!is_array($trigger)) {
                throw new InvalidArgumentException('Invalid schedule trigger');
            } else {
                $payload['trigger'] = array("periodical" => $trigger);
            }
        }

        if (count($payload) <= 0) {
            throw new InvalidArgumentException('Invalid schedule, name, enabled, trigger, push can not all be null');
        }

        $url = $this->client->makeURL('schedule') . "/" . $schedule_id;
        return $this->http->put($this->client, $url, $payload);
    }

    /**
     * @param  int  $page
     * @return array
     * @throws \Lijinhua\HyperfJpush\Exceptions\APIRequestException
     * @throws \Lijinhua\HyperfJpush\Exceptions\ServiceNotAvailable
     */
    public function getSchedules(int $page = 1): array
    {
        if (!is_int($page)) {
            $page = 1;
        }
        $url = $this->client->makeURL('schedule') . "?page=" . $page;
        return $this->http->get($this->client, $url);
    }

    /**
     * @param $schedule_id
     * @return array
     * @throws \Lijinhua\HyperfJpush\Exceptions\APIRequestException
     * @throws \Lijinhua\HyperfJpush\Exceptions\ServiceNotAvailable
     */
    public function getSchedule($schedule_id): array
    {
        if (!is_string($schedule_id)) {
            throw new InvalidArgumentException('Invalid schedule id');
        }
        $url = $this->client->makeURL('schedule') . "/" . $schedule_id;
        return $this->http->get($this->client, $url);
    }

    /**
     * @param $schedule_id
     * @return array
     * @throws \Lijinhua\HyperfJpush\Exceptions\APIRequestException
     * @throws \Lijinhua\HyperfJpush\Exceptions\ServiceNotAvailable
     */
    public function deleteSchedule($schedule_id): array
    {
        if (!is_string($schedule_id)) {
            throw new InvalidArgumentException('Invalid schedule id');
        }
        $url = $this->client->makeURL('schedule') . "/" . $schedule_id;
        return $this->http->delete($this->client, $url);
    }

    /**
     * @param $schedule_id
     * @return array
     * @throws \Lijinhua\HyperfJpush\Exceptions\APIRequestException
     * @throws \Lijinhua\HyperfJpush\Exceptions\ServiceNotAvailable
     */
    public function getMsgIds($schedule_id): array
    {
        if (!is_string($schedule_id)) {
            throw new InvalidArgumentException('Invalid schedule id');
        }
        $url = $this->client->makeURL('schedule') . '/' . $schedule_id . '/msg_ids';
        return $this->http->get($this->client, $url);
    }

}

