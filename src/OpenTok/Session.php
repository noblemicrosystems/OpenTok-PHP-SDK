<?php

/**
* OpenTok PHP Library
* http://www.tokbox.com/
*
* Copyright (c) 2011, TokBox, Inc.
* Permission is hereby granted, free of charge, to any person obtaining
* a copy of this software and associated documentation files (the "Software"),
* to deal in the Software without restriction, including without limitation
* the rights to use, copy, modify, merge, publish, distribute, sublicense,
* and/or sell copies of the Software, and to permit persons to whom the
* Software is furnished to do so, subject to the following conditions:
*
* The above copyright notice and this permission notice shall be included
* in all copies or substantial portions of the Software.
*
* THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS
* OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
* FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL
* THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
* LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
* OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
* THE SOFTWARE.
*/

namespace OpenTok;

use OpenTok\OpenTok;
use OpenTok\Util\Validators;

/**
* Represents an OpenTok session.
* <p>
* Use the OpenTok.createSession() method to create an OpenTok session. Use the
* getSessionId() method of the Session object to get the session ID.
*/
class Session
{
    /**
     * @internal
     */
    protected $sessionId;
    /**
     * @internal
     */
    protected $location;
    /**
     * @internal
     */
    protected $mediaMode;
    /**
     * @internal
     */
    protected $opentok;

    /**
     * @internal
     */
    function __construct($opentok, $sessionId, $properties = array())
    {
        // unpack arguments
        $defaults = array('mediaMode' => 'routed', 'location' => null);
        $properties = array_merge($defaults, array_intersect_key($properties, $defaults));
        list($mediaMode, $location) = array_values($properties);

        Validators::validateOpenTok($opentok);
        Validators::validateSessionId($sessionId);
        Validators::validateLocation($location);
        Validators::validateMediaMode($mediaMode);

        $this->opentok = $opentok;
        $this->sessionId = $sessionId;
        $this->location = $location;
        $this->mediaMode = $mediaMode;

    }

    /**
    * Returns the session ID, which uniquely identifies the session.
    */
    public function getSessionId()
    {
        return $this->sessionId;
    }

    /**
    * Returns the location hint IP address. See the OpenTok.createSession() method.
    */
    public function getLocation()
    {
        return $this->location;
    }

    /**
    * Returns true if the session's streams will be transmitted directly between peers; returns
    * false if the session's streams will be transmitted using the OpenTok media server.
    * See the OpenTok.createSession() method.
    */
    public function getMediaMode()
    {
        return $this->mediaMode;
    }

    /**
     * @internal
     */
    public function __toString()
    {
        return $this->sessionId;
    }

    /**
     * Creates a token for connecting to the session. In order to authenticate a user,
     * cthe client passes a token when connecting to the session.
     * <p>
     * For testing, you can also use the <a href="https://dashboard.tokbox.com/projects">OpenTok
     * dashboard</a> page to generate test tokens.
     *
     * @param array $options This array defines options for the token. This array include the
     * following keys, all of which are optional:
     *
     * <ul>
     *
     *    <li><code>'role'</code> (string) &mdash; One of the constants defined in the RoleConstants
     *    class. The default role is publisher</li>
     *
     *    <li><code>'expireTime'</code> (int) &mdash; The timestamp for when the token expires,
     *    in milliseconds since the Unix epoch. The default expiration time is 24 hours
     *    after the token creation time. The maximum expiration time is 30 days after the
     *    token creation time.</li>
     *
     *    <li><code>'data'</code> (string) &mdash; A string containing connection metadata
     *    describing the end-user. For example, you can pass the user ID, name, or other data
     *    describing the end-user. The length of the string is limited to 1000 characters.
     *    This data cannot be updated once it is set.</li>
     *
     * </ul>
     *
     * @return string The token string.
     */
    public function generateToken($options = array())
    {
        return $this->opentok->generateToken($this->sessionId, $options);
    }

}

/* vim: set ts=4 sw=4 tw=100 sts=4 et :*/
