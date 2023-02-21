<?php

namespace Lijinhua\HyperfJpush\Payloads;

use InvalidArgumentException;

class DevicePayload extends AbstractPayload
{

    /**
     * @param $registrationId
     * @return array
     * @throws \Lijinhua\HyperfJpush\Exceptions\APIRequestException
     * @throws \Lijinhua\HyperfJpush\Exceptions\ServiceNotAvailable
     */
    public function getDevices($registrationId): array
    {
        $url = $this->client->makeURL('device') . $registrationId;
        return $this->http->get($this->client, $url);
    }

    /**
     * @param $registration_id
     * @param $alias
     * @return array
     * @throws \Lijinhua\HyperfJpush\Exceptions\APIRequestException
     * @throws \Lijinhua\HyperfJpush\Exceptions\ServiceNotAvailable
     */
    public function updateAlias($registration_id, $alias): array
    {
        return $this->updateDevice($registration_id, $alias);
    }

    /**
     * @param $registration_id
     * @param $tags
     * @return array
     * @throws \Lijinhua\HyperfJpush\Exceptions\APIRequestException
     * @throws \Lijinhua\HyperfJpush\Exceptions\ServiceNotAvailable
     */
    public function addTags($registration_id, $tags): array
    {
        $tags = is_array($tags) ? $tags : array($tags);
        return $this->updateDevice($registration_id, null, null, $tags);
    }

    /**
     * @param $registration_id
     * @param $tags
     * @return array
     * @throws \Lijinhua\HyperfJpush\Exceptions\APIRequestException
     * @throws \Lijinhua\HyperfJpush\Exceptions\ServiceNotAvailable
     */
    public function removeTags($registration_id, $tags): array
    {
        $tags = is_array($tags) ? $tags : array($tags);
        return $this->updateDevice($registration_id, null, null, null, $tags);
    }

    /**
     * @param $registration_id
     * @param $mobile
     * @return array
     * @throws \Lijinhua\HyperfJpush\Exceptions\APIRequestException
     * @throws \Lijinhua\HyperfJpush\Exceptions\ServiceNotAvailable
     */
    public function updateMobile($registration_id, $mobile): array
    {
        return $this->updateDevice($registration_id, null, $mobile);
    }

    /**
     * @param $registrationId
     * @return array
     * @throws \Lijinhua\HyperfJpush\Exceptions\APIRequestException
     * @throws \Lijinhua\HyperfJpush\Exceptions\ServiceNotAvailable
     */
    public function clearMobile($registrationId): array
    {
        $url = $this->client->makeURL('device') . $registrationId;
        return $this->http->post($this->client, $url, ['mobile' => '']);
    }

    /**
     * @param $registrationId
     * @return array
     * @throws \Lijinhua\HyperfJpush\Exceptions\APIRequestException
     * @throws \Lijinhua\HyperfJpush\Exceptions\ServiceNotAvailable
     */
    public function clearTags($registrationId): array
    {
        $url = $this->client->makeURL('device') . $registrationId;
        return $this->http->post($this->client, $url, ['tags' => '']);
    }

    /**
     * @param $registrationId
     * @param $alias
     * @param $mobile
     * @param $addTags
     * @param $removeTags
     * @return array
     * @throws \Lijinhua\HyperfJpush\Exceptions\APIRequestException
     * @throws \Lijinhua\HyperfJpush\Exceptions\ServiceNotAvailable
     */
    public function updateDevice(
        $registrationId,
        $alias = null,
        $mobile = null,
        $addTags = null,
        $removeTags = null
    ): array {
        $payload = array();
        if (!is_string($registrationId)) {
            throw new InvalidArgumentException('Invalid registration_id');
        }

        $aliasIsNull      = is_null($alias);
        $mobileIsNull     = is_null($mobile);
        $addTagsIsNull    = is_null($addTags);
        $removeTagsIsNull = is_null($removeTags);

        if ($aliasIsNull && $addTagsIsNull && $removeTagsIsNull && $mobileIsNull) {
            throw new InvalidArgumentException("alias, addTags, removeTags not all null");
        }

        if (!$aliasIsNull) {
            if (is_string($alias)) {
                $payload['alias'] = $alias;
            } else {
                throw new InvalidArgumentException("Invalid alias string");
            }
        }

        if (!$mobileIsNull) {
            if (is_string($mobile)) {
                $payload['mobile'] = $mobile;
            } else {
                throw new InvalidArgumentException("Invalid mobile string");
            }
        }

        $tags = array();

        if (!$addTagsIsNull) {
            if (is_array($addTags)) {
                $tags['add'] = $addTags;
            } else {
                throw new InvalidArgumentException("Invalid addTags array");
            }
        }

        if (!$removeTagsIsNull) {
            if (is_array($removeTags)) {
                $tags['remove'] = $removeTags;
            } else {
                throw new InvalidArgumentException("Invalid removeTags array");
            }
        }

        if (count($tags) > 0) {
            $payload['tags'] = $tags;
        }

        $url = $this->client->makeURL('device') . $registrationId;
        return $this->http->post($this->client, $url, $payload);
    }

    /**
     * @return array
     * @throws \Lijinhua\HyperfJpush\Exceptions\APIRequestException
     * @throws \Lijinhua\HyperfJpush\Exceptions\ServiceNotAvailable
     */
    public function getTags(): array
    {
        $url = $this->client->makeURL('tag');
        return $this->http->get($this->client, $url);
    }

    /**
     * @param $registrationId
     * @param $tag
     * @return array
     * @throws \Lijinhua\HyperfJpush\Exceptions\APIRequestException
     * @throws \Lijinhua\HyperfJpush\Exceptions\ServiceNotAvailable
     */
    public function isDeviceInTag($registrationId, $tag): array
    {
        if (!is_string($registrationId)) {
            throw new InvalidArgumentException("Invalid registration_id");
        }

        if (!is_string($tag)) {
            throw new InvalidArgumentException("Invalid tag");
        }
        $url = $this->client->makeURL('tag') . $tag . '/registration_ids/' . $registrationId;
        return $this->http->get($this->client, $url);
    }

    /**
     * @param $tag
     * @param $addDevices
     * @return array
     * @throws \Lijinhua\HyperfJpush\Exceptions\APIRequestException
     * @throws \Lijinhua\HyperfJpush\Exceptions\ServiceNotAvailable
     */
    public function addDevicesToTag($tag, $addDevices): array
    {
        $device = is_array($addDevices) ? $addDevices : array($addDevices);
        return $this->updateTag($tag, $device);
    }

    /**
     * @param $tag
     * @param $removeDevices
     * @return array
     * @throws \Lijinhua\HyperfJpush\Exceptions\APIRequestException
     * @throws \Lijinhua\HyperfJpush\Exceptions\ServiceNotAvailable
     */
    public function removeDevicesFromTag($tag, $removeDevices): array
    {
        $device = is_array($removeDevices) ? $removeDevices : array($removeDevices);
        return $this->updateTag($tag, null, $device);
    }

    /**
     * @param $tag
     * @param $addDevices
     * @param $removeDevices
     * @return array
     * @throws \Lijinhua\HyperfJpush\Exceptions\APIRequestException
     * @throws \Lijinhua\HyperfJpush\Exceptions\ServiceNotAvailable
     */
    public function updateTag($tag, $addDevices = null, $removeDevices = null): array
    {
        if (!is_string($tag)) {
            throw new InvalidArgumentException("Invalid tag");
        }

        $addDevicesIsNull    = is_null($addDevices);
        $removeDevicesIsNull = is_null($removeDevices);

        if ($addDevicesIsNull && $removeDevicesIsNull) {
            throw new InvalidArgumentException("Either or both addDevices and removeDevices must be set.");
        }

        $registrationId = array();

        if (!$addDevicesIsNull) {
            if (is_array($addDevices)) {
                $registrationId['add'] = $addDevices;
            } else {
                throw new InvalidArgumentException("Invalid addDevices");
            }
        }

        if (!$removeDevicesIsNull) {
            if (is_array($removeDevices)) {
                $registrationId['remove'] = $removeDevices;
            } else {
                throw new InvalidArgumentException("Invalid removeDevices");
            }
        }

        $url     = $this->client->makeURL('tag') . $tag;
        $payload = array('registration_ids' => $registrationId);
        return $this->http->post($this->client, $url, $payload);
    }

    /**
     * @param $tag
     * @return array
     * @throws \Lijinhua\HyperfJpush\Exceptions\APIRequestException
     * @throws \Lijinhua\HyperfJpush\Exceptions\ServiceNotAvailable
     */
    public function deleteTag($tag): array
    {
        if (!is_string($tag)) {
            throw new InvalidArgumentException("Invalid tag");
        }
        $url = $this->client->makeURL('tag') . $tag;
        return $this->http->delete($this->client, $url);
    }

    /**
     * @param $alias
     * @param $platform
     * @return array
     * @throws \Lijinhua\HyperfJpush\Exceptions\APIRequestException
     * @throws \Lijinhua\HyperfJpush\Exceptions\ServiceNotAvailable
     */
    public function getAliasDevices($alias, $platform = null): array
    {
        if (!is_string($alias)) {
            throw new InvalidArgumentException("Invalid alias");
        }

        $url = $this->client->makeURL('alias') . $alias;

        if (!is_null($platform)) {
            if (is_array($platform)) {
                $isFirst = true;
                foreach ($platform as $item) {
                    if ($isFirst) {
                        $url     = $url . '?platform=' . $item;
                        $isFirst = false;
                    } else {
                        $url = $url . ',' . $item;
                    }
                }
            } else {
                if (is_string($platform)) {
                    $url = $url . '?platform=' . $platform;
                } else {
                    throw new InvalidArgumentException("Invalid platform");
                }
            }
        }
        return $this->http->get($this->client, $url);
    }

    /**
     * @param $alias
     * @return array
     * @throws \Lijinhua\HyperfJpush\Exceptions\APIRequestException
     * @throws \Lijinhua\HyperfJpush\Exceptions\ServiceNotAvailable
     */
    public function deleteAlias($alias): array
    {
        if (!is_string($alias)) {
            throw new InvalidArgumentException("Invalid alias");
        }
        $url = $this->client->makeURL('alias') . $alias;
        return $this->http->delete($this->client, $url);
    }

    /**
     * @param $registrationId
     * @return array
     * @throws \Lijinhua\HyperfJpush\Exceptions\APIRequestException
     * @throws \Lijinhua\HyperfJpush\Exceptions\ServiceNotAvailable
     */
    public function getDevicesStatus($registrationId): array
    {
        if (!is_array($registrationId) && !is_string($registrationId)) {
            throw new InvalidArgumentException('Invalid registration_id');
        }

        if (is_string($registrationId)) {
            $registrationId = explode(',', $registrationId);
        }

        $payload = array();
        if (count($registrationId) <= 0) {
            throw new InvalidArgumentException('Invalid registration_id');
        }
        $payload['registration_ids'] = $registrationId;
        $url                         = $this->client->makeURL('device') . 'status';
        return $this->http->post($this->client, $url, $payload);
    }
}
