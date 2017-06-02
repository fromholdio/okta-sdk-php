<?php
/*******************************************************************************
 * Copyright 2017 Okta, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *      http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 ******************************************************************************/

namespace Okta\Users;

use Okta\Resource\AbstractResource;

class User extends AbstractResource
{
    const ID = 'id';
    const LINKS = '_links';
    const STATUS = 'status';
    const CREATED = 'created';
    const PROFILE = 'profile';
    const EMBEDDED = '_embedded';
    const ACTIVATED = 'activated';
    const LAST_LOGIN = 'lastLogin';
    const CREDENTIALS = 'credentials';
    const LAST_UPDATED = 'lastUpdated';
    const STATUS_CHANGED = 'statusChanged';
    const PASSWORD_CHANGED = 'passwordChanged';
    const TRANSITIONING_TO_STATUS = 'transitioningToStatus';

    /**
     * @return string
     */
    public function getId()
    {
        return $this->getProperty(self::ID);
    }
    
    /**
     * @return hash
     */
    public function getLinks()
    {
        return $this->getProperty(self::LINKS);
    }
    
    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->getProperty(self::STATUS);
    }
    
    /**
     * @return \Carbon\Carbon|null
     */
    public function getCreated()
    {
        return $this->getDateProperty(self::CREATED);
    }
    
    /**
     * @return UserProfile
     */
    public function getProfile(array $options = [])
    {
        return $this->getResourceProperty(
            self::PROFILE,
            UserProfile::class,
            $options
        );
    }

    /**
     * @return self
     */
    public function setProfile(UserProfile $profile)
    {
        $this->setResourceProperty(
            self::PROFILE,
            $profile
        );
        
        return $this;
    }
    
    /**
     * @return hash
     */
    public function getEmbedded()
    {
        return $this->getProperty(self::EMBEDDED);
    }
    
    /**
     * @return \Carbon\Carbon|null
     */
    public function getActivated()
    {
        return $this->getDateProperty(self::ACTIVATED);
    }
    
    /**
     * @return \Carbon\Carbon|null
     */
    public function getLastLogin()
    {
        return $this->getDateProperty(self::LAST_LOGIN);
    }
    
    /**
     * @return UserCredentials
     */
    public function getCredentials(array $options = [])
    {
        return $this->getResourceProperty(
            self::CREDENTIALS,
            UserCredentials::class,
            $options
        );
    }

    /**
     * @return self
     */
    public function setCredentials(UserCredentials $credentials)
    {
        $this->setResourceProperty(
            self::CREDENTIALS,
            $credentials
        );
        
        return $this;
    }
    
    /**
     * @return \Carbon\Carbon|null
     */
    public function getLastUpdated()
    {
        return $this->getDateProperty(self::LAST_UPDATED);
    }
    
    /**
     * @return \Carbon\Carbon|null
     */
    public function getStatusChanged()
    {
        return $this->getDateProperty(self::STATUS_CHANGED);
    }
    
    /**
     * @return \Carbon\Carbon|null
     */
    public function getPasswordChanged()
    {
        return $this->getDateProperty(self::PASSWORD_CHANGED);
    }
    
    /**
     * @return string
     */
    public function getTransitioningToStatus()
    {
        return $this->getProperty(self::TRANSITIONING_TO_STATUS);
    }
    
    public function getGroups(array $options = [])
    {
        return $this
                ->getDataStore()
                ->getCollection(
                    "/api/v1/users/{$this->getId()}/groups",
                    UserGroup::class,
                    Collection::class,
                    $options
                );
    }
    public function activate($sendEmail = true)
    {
        $uri = "{$this->getDataStore()->getOrganizationUrl}/api/v1/users/{$this->getId()}/lifecycle/activate";
        return $this
                ->getDataStore()
                ->executeRequest(
                    'POST',
                    $uri,
                    '',
                    ['query' => ['sendEmail' => $sendEmail]]
                );
    }
    public function deactivate()
    {
        $uri = "{$this->getDataStore()->getOrganizationUrl}/api/v1/users/{$this->getId()}/lifecycle/deactivate";
        return $this
                ->getDataStore()
                ->executeRequest(
                    'POST',
                    $uri
                );
    }
    public function suspend()
    {
        $uri = "{$this->getDataStore()->getOrganizationUrl}/api/v1/users/{$this->getId()}/lifecycle/suspend";
        return $this
                ->getDataStore()
                ->executeRequest(
                    'POST',
                    $uri
                );
    }
    public function unsuspend()
    {
        $uri = "{$this->getDataStore()->getOrganizationUrl}/api/v1/users/{$this->getId()}/lifecycle/unsuspend";
        return $this
                ->getDataStore()
                ->executeRequest(
                    'POST',
                    $uri
                );
    }
    public function unlock()
    {
        $uri = "{$this->getDataStore()->getOrganizationUrl}/api/v1/users/{$this->getId()}/lifecycle/unlock";
        return $this
                ->getDataStore()
                ->executeRequest(
                    'POST',
                    $uri
                );
    }
    public function forgotPassword($sendEmail = true)
    {
        $uri = "{$this->getDataStore()->getOrganizationUrl}/api/v1/users/{$this->getId()}/lifecycle/forgot_password";
        return $this
                ->getDataStore()
                ->executeRequest(
                    'POST',
                    $uri,
                    '',
                    ['query' => ['sendEmail' => $sendEmail]]
                );
    }
    public function resetFactors()
    {
        $uri = "{$this->getDataStore()->getOrganizationUrl}/api/v1/users/{$this->getId()}/lifecycle/reset_factors";
        return $this
                ->getDataStore()
                ->executeRequest(
                    'POST',
                    $uri
                );
    }
    public function addToGroup()
    {
        $uri = "{$this->getDataStore()->getOrganizationUrl}/api/v1/groups/{groupId}/users/{$this->getId()}";
        return $this
                ->getDataStore()
                ->executeRequest(
                    'PUT',
                    $uri
                );
    }
}