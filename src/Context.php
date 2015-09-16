<?php

/*
 * This file is part of the ModelTransformer package
 *
 * (c) FiveLab
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code
 */

namespace FiveLab\Component\ModelTransformer;

/**
 * Base context
 *
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
class Context implements ContextInterface
{
    /**
     * @var array
     */
    private $groups = [];

    /**
     * {@inheritDoc}
     */
    public function setGroups(array $groups)
    {
        $this->groups = $groups;

        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * {@inheritDoc}
     */
    public function hasGroup($group)
    {
        return in_array($group, $this->groups, true);
    }
}
