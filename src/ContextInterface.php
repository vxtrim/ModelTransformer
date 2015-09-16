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
 * All model transformer context should be implemented of this interface
 *
 * @author Vitaliy Zhuk <v.zhuk@fivelab.org>
 */
interface ContextInterface
{
    /**
     * Set groups
     *
     * @param array $groups
     *
     * @return Context
     */
    public function setGroups(array $groups);

    /**
     * Get groups
     *
     * @return array
     */
    public function getGroups();

    /**
     * Has group
     *
     * @param string $group
     */
    public function hasGroup($group);
}
