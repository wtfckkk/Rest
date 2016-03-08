<?php

namespace Slim\Interfaces;

interface ContactServiceInterface
{

    /**
     *
     * Fetches contacts that match the specified criteria.
     *
     * If no criteria specified, the result will fetch the last 10 contacts on
     * the database.
     * Field will specify which field will be used for sorting.
     * $skip will define the page of the results and $limit will define how many
     * contacts the request should return.
     *
     * In case of error, the function should throw an exception.
     *
     * Array result looks like this:
     *
     * ```
     * {
     *   "total":100,
     *   "result":[
     *     {
     *        "id":24,
     *        "name":"John",
     *        "last_name":"Doe",
     *        "email":"john.doe@mail.com",
     *        "status":{
     *          "id":3,
     *          "name":"active",
     *          "description":""
     *        },
     *        "last_activity":"2015-03-16 23:09:19",
     *        "created":"2015-10-07 12:43:13"
     *     },
     *     ...
     *   ]
     * }
     * ```
     *
     * @param string $field
     * @param string $order
     * @param int $skip
     * @param int $limit
     * @return array|\Exception     Throws an exception when bad arguments are given or DB access problems.
     */
    public function getContacts($field = null, $order = 'desc', $skip = 0, $limit = 10);

    /**
     *
     * Flags contacts with the specified flag.
     *
     * @param array $contacts       An array of contact IDs
     * @param int $flagId           The flag ID
     * @return array|\Exception     Throws exception when a contact and/or flag is not found or DB access problems.
     *
     * Array result should look like this:
     *
     * ```
     * {
     *   "total":10,
     *   "result":[14,264,36] //each contact
     * }
     * ```
     *
     */
    public function flagContacts(array $contacts, $flagId);

}