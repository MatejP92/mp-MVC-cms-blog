-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 09, 2023 at 04:35 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mvc_blog_cms_mp`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `author` varchar(255) NOT NULL,
  `content` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `comment_post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `author` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created` date NOT NULL DEFAULT current_timestamp(),
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `posts`
--

INSERT INTO `posts` (`id`, `title`, `author`, `content`, `created`, `status`) VALUES
(9, 'test post 9', 'admin', 'Eos odio facilisis. Exercitationem, donec. Habitasse quos ligula erat soluta dis minima risus diam ultricies quibusdam mus! Eaque? Laborum alias. Nostrud quae dolores voluptates quibusdam harum sed senectus? Labore aliqua volutpat. Ultrices, illum odit accusamus, quae lacinia atque voluptas rem praesent mi cubilia aut proin atque torquent atque. Vivamus lacinia, metus mauris! Sapien magnis dictum eos per eu, imperdiet molestias, aspernatur alias nisl dolor rerum eaque tempora eum natoque facilis, per lacinia, saepe perferendis est laboriosam suscipit lorem orci eveniet, nostrud? Metus wisi amet, lacus erat sociis asperiores et sapien! Consequatur itaque, ridiculus esse eum, facilisis rhoncus nunc, minima cumque.', '2022-12-31', 'published'),
(10, 'test post 10 edited', 'admin', 'Repellendus euismod quisque exercitation? Dolores, minima nostrud morbi expedita mollit magnam inceptos, nec quibusdam suscipit quisquam earum quis. Quasi quasi! Conubia, nesciunt venenatis unde, facilis blanditiis! Fringilla quaerat deserunt imperdiet minima quod etiam sagittis, similique! Sem, elementum mollitia aperiam nostrum, natoque atque. Blandit accusamus posuere, dignissim eros odit! Incididunt deserunt tempora nam tenetur augue consectetur eum pariatur, nobis commodi feugiat, dignissim tristique quae, mattis per corporis earum iaculis, labore minima lacus, error, dolor semper? Lacinia! Ipsam tellus, lorem modi rutrum malesuada minus conubia ipsam enim? Tortor minus at. Pharetra duis! Voluptatem varius optio, felis in explicabo, commodi commodi, tellus diamlorem.', '2022-12-31', 'unpublished'),
(13, 'Test Post 13 edited 2', 'admin', 'Vulputate nemo, incididunt, eu sequi reprehenderit! Odio, sit justo ligula quidem adipisicing accusantium cumque! Cubilia exercitationem, debitis. Natoque diamlorem commodo, occaecati purus lobortis lorem aut, consequuntur, distinctio, dolorum voluptatum felis, mollitia impedit, provident ullamco! Donec tempore, donec mollis. Quasi hymenaeos, tenetur dolorum quasi? Quod impedit torquent tempus posuere, minus ipsa congue? Nihil necessitatibus excepteur eros assumenda ex ac ipsam voluptates! Sem expedita blanditiis fugit aliquip orci, iusto hymenaeos ullam veniam sagittis cupiditate, nam lacus luctus distinctio etiam ligula, explicabo atque blandit! Integer ullamcorper massa feugiat vivamus blanditiis ultrices, odit cupidatat. Gravida modi torquent egestas odio facilis, dignissimos rutrum, architecto animi.', '2023-01-02', 'published'),
(14, 'Test post 14 edited', 'admin', 'Erat penatibus eiusmod habitant? Donec ac? Ultrices reiciendis numquam! Aliquam curae urna. Habitasse voluptas proin, placeat, reiciendis aliqua, elit et, feugiat optio litora commodi nunc nam penatibus mus sociosqu primis orci hendrerit. Montes? Egestas sint. Conubia itaque? Vestibulum cubilia, ridiculus litora est, culpa saepe iure aenean dolores cupidatat sagittis sit, interdum expedita, inventore molestiae? Eaque quidem omnis dolores qui numquam! Nunc quas! Lacus voluptas consectetuer, ipsum praesentium tristique facere nonummy laboris fusce! Corrupti aspernatur laoreet, facilisis, illum magni orci egestas! Modi taciti lacus aliquet, deserunt libero adipisci, minim inceptos dapibus! Accusantium voluptas debitis quisque fames, veniam, sit. Nullam, sodales, fugiat.', '2023-01-03', 'published'),
(16, 'test Post 16', 'admin', '&#60;h2&#62;test 2&#60;br&#62;&#38;nbsp;&#60;/h2&#62;&#60;p&#62;test Fugit cupidatat explicabo. Sem, fuga nascetur convallis, unde corporis voluptas placerat tempora? Dolorem facere error potenti, ullam lorem fringilla urna, sapiente? Aut tellus recusandae. Beatae est nesciunt repudiandae, cumque consectetur quisque iaculis officiis lectus erat diam! Fusce in? Nibh fuga? Omnis quibusdam. Diamlorem? Hendrerit officia, saepe officiis facere, duis doloremque fuga sint. Est iaculis aspernatur culpa tortor voluptates aliquid sagittis! Elementum eleifend, eaque quisque, consectetur quam maiores ullam dicta, nesciunt! Proident repellat, fames turpis. Sunt fermentum nihil, laoreet, volutpat repellat sapiente dolor reprehenderit semper! Fugiat, ullamco nisl soluta, eius officiis quae sapien necessitatibus ducimus vero eveniet erat praesent arcu, eum.&#60;/p&#62;', '2023-01-04', 'published'),
(23, 'Adipisicing voluptat', 'test', '&#60;p&#62;Repellat alias deleniti amet, litora nobis? Cupiditate magnis culpa? Nostra elit. Ipsum. Facilisi in, totam ac, netus augue blandit omnis lobortis nostrud recusandae placeat sequi orci dapibus semper! Eum accusamus accusamus hendrerit et fuga dapibus aliquip! Eros perferendis blandit ligula mattis inventore sem nihil. Ac incididunt pellentesque eget, est voluptates nostrum sapiente adipiscing natoque deleniti commodo! Magnis, aliquet doloremque repellendus natus maxime felis maiores auctor? Commodi, expedita expedita corporis debitis faucibus sequi! Libero mollitia tristique? Omnis, ut facilisi, molestiae elit voluptate optio volutpat consequat assumenda ornare? Libero. Impedit? Potenti, integer justo elit repudiandae, etiam, distinctio auctor, laboris ad, scelerisque, est.&#60;/p&#62;', '2023-01-09', 'published'),
(24, 'Ipsam corporis aliqu edit', 'test', '&#60;p&#62;Praesent magnis lobortis. Praesent explicabo ad, nullam laboriosam, veritatis maecenas mus ipsam? Pulvinar, suspendisse. Porro impedit occaecati! Curae quae ex? Laboriosam quia sed! Aliquet. Lacus consequatur diamlorem adipiscing? Expedita proin enim cumque mi hymenaeos do asperiores? Vulputate commodi maecenas orci doloribus laudantium arcu voluptates asperiores? Repudiandae at quos rutrum delectus? Consequatur exercitationem aliquip error ultricies, nec, adipiscing sed nisl semper, aut vulputate voluptatum? Similique culpa lorem! Architecto penatibus sed. Volutpat, assumenda ligula corrupti ullam suspendisse, nobis, iaculis suspendisse mollit proin ullam? Aliquet, cupidatat volutpat, aliquam, ornare est doloribus erat minim, ea blanditiis ipsum aut, voluptates nam purus nunc, senectus voluptatibus.&#60;/p&#62;', '2023-01-09', 'unpublished');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `firstname` varchar(255) DEFAULT NULL,
  `lastname` varchar(255) DEFAULT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` varchar(255) NOT NULL DEFAULT 'subscriber',
  `created` datetime NOT NULL DEFAULT current_timestamp(),
  `token` text NOT NULL,
  `expire` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `firstname`, `lastname`, `email`, `password`, `role`, `created`, `token`, `expire`) VALUES
(14, 'admin', 'admin', 'admin', 'admin@gmail.com', '$2y$10$Nuv0bGeKKJLbzYMHSzdo3OYg0/Ykfgp1NJzuWjHI9V2vr4GtYSLMa', 'admin', '2022-12-16 10:13:53', '', '2023-01-06 00:00:00'),
(29, 'sipoqy', NULL, NULL, 'noqifuqip@mailinator.com', '$2y$10$XNv1eVcqd1w23VBUJXKIweUw4U.lcjzpLVjTu0r/F7j4pxysOVlgy', 'subscriber', '2023-01-04 17:38:44', '', '2023-01-06 00:00:00'),
(30, 'dedexoho', NULL, NULL, 'sudeqig@mailinator.com', '$2y$10$xUxCOSljFAItPspbN4zOm.PvykzluoFW4t/KTHNqQU3RPvCZagsFy', 'subscriber', '2023-01-04 17:43:30', '', '2023-01-06 00:00:00'),
(33, 'test', NULL, NULL, 'test@email.com', '$2y$10$k4M.U94b1vxppY8kYhUmq.pei1Bi0FAmPIqny7cbK05xIL9rIVHRC', 'subscriber', '2023-01-09 16:20:08', '', '0000-00-00 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
