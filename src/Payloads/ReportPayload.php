<?php

namespace Lijinhua\HyperfJpush\Payloads;

use InvalidArgumentException;

class ReportPayload extends AbstractPayload
{
    const EFFECTIVE_TIME_UNIT = ['HOUR', 'DAY', 'MONTH'];

    /**
     * @param $msgIds
     * @return array
     * @throws \Lijinhua\HyperfJpush\Exceptions\APIRequestException
     * @throws \Lijinhua\HyperfJpush\Exceptions\ServiceNotAvailable
     */
    public function getReceived($msgIds): array
    {
        $queryParams = '?msg_ids=';
        if (is_array($msgIds) && !empty($msgIds)) {
            $msgIdsStr   = implode(',', $msgIds);
            $queryParams .= $msgIdsStr;
        } elseif (is_string($msgIds)) {
            $queryParams .= $msgIds;
        } else {
            throw new InvalidArgumentException("Invalid msg_ids");
        }

        $url = $this->client->makeURL('report') . 'received' . $queryParams;
        return $this->http->get($this->client, $url);
    }

    /**
     * 送达统计详情（新）
     * https://docs.jiguang.cn/jpush/server/push/rest_api_v3_report/#_7
     *
     * @param $msgIds
     * @return array
     * @throws \Lijinhua\HyperfJpush\Exceptions\APIRequestException
     * @throws \Lijinhua\HyperfJpush\Exceptions\ServiceNotAvailable
     */
    public function getReceivedDetail($msgIds): array
    {
        $queryParams = '?msg_ids=';
        if (is_array($msgIds) && !empty($msgIds)) {
            $msgIdsStr   = implode(',', $msgIds);
            $queryParams .= $msgIdsStr;
        } elseif (is_string($msgIds)) {
            $queryParams .= $msgIds;
        } else {
            throw new InvalidArgumentException("Invalid msg_ids");
        }

        $url = $this->client->makeURL('report') . 'received/detail' . $queryParams;
        return $this->http->get($this->client, $url);
    }

    /**
     * @param $msgId
     * @param $rids
     * @param $data
     * @return array
     * @throws \Lijinhua\HyperfJpush\Exceptions\APIRequestException
     * @throws \Lijinhua\HyperfJpush\Exceptions\ServiceNotAvailable
     */
    public function getMessageStatus($msgId, $rids, $data = null): array
    {
        $url             = $this->client->makeURL('report') . 'status/message';
        $registrationIds = is_array($rids) ? $rids : array($rids);
        $body            = [
            'msg_id'           => $msgId,
            'registration_ids' => $registrationIds,
        ];
        if (!is_null($data)) {
            $body['data'] = $data;
        }
        return $this->http->post($this->client, $url, $body);
    }

    /**
     * @param $msgIds
     * @return array
     * @throws \Lijinhua\HyperfJpush\Exceptions\APIRequestException
     * @throws \Lijinhua\HyperfJpush\Exceptions\ServiceNotAvailable
     */
    public function getMessages($msgIds): array
    {
        $queryParams = '?msg_ids=';
        if (is_array($msgIds) && !empty($msgIds)) {
            $msgIdsStr   = implode(',', $msgIds);
            $queryParams .= $msgIdsStr;
        } elseif (is_string($msgIds)) {
            $queryParams .= $msgIds;
        } else {
            throw new InvalidArgumentException("Invalid msg_ids");
        }

        $url = $this->client->makeURL('report') . 'messages/' . $queryParams;
        return $this->http->get($this->client, $url);
    }

    /**
     * 消息统计详情（VIP 专属接口，新）
     * https://docs.jiguang.cn/jpush/server/push/rest_api_v3_report/#vip_1
     *
     * @param $msgIds
     * @return array
     * @throws \Lijinhua\HyperfJpush\Exceptions\APIRequestException
     * @throws \Lijinhua\HyperfJpush\Exceptions\ServiceNotAvailable
     */
    public function getMessagesDetail($msgIds): array
    {
        $queryParams = '?msg_ids=';
        if (is_array($msgIds) && !empty($msgIds)) {
            $msgIdsStr   = implode(',', $msgIds);
            $queryParams .= $msgIdsStr;
        } elseif (is_string($msgIds)) {
            $queryParams .= $msgIds;
        } else {
            throw new InvalidArgumentException("Invalid msg_ids");
        }

        $url = $this->client->makeURL('report') . 'messages/detail' . $queryParams;
        return $this->http->get($this->client, $url);
    }

    /**
     * @param $time_unit
     * @param $start
     * @param $duration
     * @return array
     * @throws \Lijinhua\HyperfJpush\Exceptions\APIRequestException
     * @throws \Lijinhua\HyperfJpush\Exceptions\ServiceNotAvailable
     */
    public function getUsers($time_unit, $start, $duration): array
    {
        $time_unit = strtoupper($time_unit);
        if (!in_array($time_unit, self::EFFECTIVE_TIME_UNIT)) {
            throw new InvalidArgumentException('Invalid time unit');
        }

        $url = $this->client->makeURL('report') . 'users/?time_unit=' . $time_unit . '&start=' . $start . '&duration=' . $duration;
        return $this->http->get($this->client, $url);
    }
}
