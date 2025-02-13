<?php

namespace EvoFone\Resources;

use EvoFone\FoneEvo;

class Group extends Resource
{
    /**
     * The ID of the group.
     *
     * @var string
     */
    public $id;

    /**
     * The subject or name of the group.
     *
     * @var string
     */
    public $subject;

    /**
     * The owner of the subject.
     *
     * @var string
     */
    public $subjectOwner;

    /**
     * The timestamp of the subject creation.
     *
     * @var int
     */
    public $subjectTime;

    /**
     * The URL of the group picture.
     *
     * @var string|null
     */
    public $pictureUrl;

    /**
     * The size of the group.
     *
     * @var int
     */
    public $size;

    /**
     * The creation timestamp of the group.
     *
     * @var int
     */
    public $creation;

    /**
     * The owner of the group.
     *
     * @var string
     */
    public $owner;

    /**
     * The description of the group.
     *
     * @var string
     */
    public $desc;

    /**
     * The ID of the description.
     *
     * @var string
     */
    public $descId;

    /**
     * Whether the group is restricted.
     *
     * @var bool
     */
    public $restrict;

    /**
     * Whether the group is announcement-only.
     *
     * @var bool
     */
    public $announce;

    /**
     * Whether the group is announcement-only.
     *
     * @var bool
     */
    public $isCommunity;

    /**
     * Whether the group is announcement-only.
     *
     * @var bool
     */
    public $isCommunityAnnounce;

    /**
     * Instance settings.
     *
     * @var array
     */
    public $participants;

    /**
     * Create a new Group resource.
     *
     * @param  array  $attributes
     * @param  FoneEvo  $foneEvo
     */
    public function __construct(array $attributes, FoneEvo $foneEvo)
    {
        parent::__construct($attributes, $foneEvo);

        $this->id = $attributes['id'];
        $this->subject = $attributes['subject'];
        $this->subjectOwner = $attributes['subjectOwner'] ?? null;
        $this->subjectTime = $attributes['subjectTime'];
        $this->pictureUrl = $attributes['pictureUrl'] ?? null;
        $this->size = $attributes['size'];
        $this->creation = $attributes['creation'];
        $this->owner = $attributes['owner'] ?? null;
        $this->desc = $attributes['desc'] ?? null;
        $this->descId = $attributes['descId'] ?? null;
        $this->restrict = $attributes['restrict'];
        $this->announce = $attributes['announce'];
        $this->isCommunity = $attributes['isCommunity'];
        $this->isCommunityAnnounce = $attributes['isCommunityAnnounce'];
        $this->participants = $attributes['participants'] ?? [];
    }
}
