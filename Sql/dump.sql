--
-- PostgreSQL database dump
--

-- Dumped from database version 16.3
-- Dumped by pg_dump version 16.3

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: digidb; Type: DATABASE; Schema: -; Owner: roost
--

CREATE DATABASE digidb WITH TEMPLATE = template0 ENCODING = 'UTF8' LOCALE_PROVIDER = libc LOCALE = 'en_US.utf8';


ALTER DATABASE digidb OWNER TO roost;

\connect digidb

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- Name: public; Type: SCHEMA; Schema: -; Owner: pg_database_owner
--

CREATE SCHEMA public;


ALTER SCHEMA public OWNER TO pg_database_owner;

--
-- Name: SCHEMA public; Type: COMMENT; Schema: -; Owner: pg_database_owner
--

COMMENT ON SCHEMA public IS 'standard public schema';


SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- Name: categories; Type: TABLE; Schema: public; Owner: roost
--

CREATE TABLE public.categories (
    id bigint NOT NULL,
    title character varying(255) NOT NULL,
    slug character varying(255) NOT NULL,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


ALTER TABLE public.categories OWNER TO roost;

--
-- Name: categories_id_seq; Type: SEQUENCE; Schema: public; Owner: roost
--

CREATE SEQUENCE public.categories_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.categories_id_seq OWNER TO roost;

--
-- Name: categories_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: roost
--

ALTER SEQUENCE public.categories_id_seq OWNED BY public.categories.id;


--
-- Name: failed_jobs; Type: TABLE; Schema: public; Owner: roost
--

CREATE TABLE public.failed_jobs (
    id bigint NOT NULL,
    uuid character varying(255) NOT NULL,
    connection text NOT NULL,
    queue text NOT NULL,
    payload text NOT NULL,
    exception text NOT NULL,
    failed_at timestamp(0) without time zone DEFAULT CURRENT_TIMESTAMP NOT NULL
);


ALTER TABLE public.failed_jobs OWNER TO roost;

--
-- Name: failed_jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: roost
--

CREATE SEQUENCE public.failed_jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.failed_jobs_id_seq OWNER TO roost;

--
-- Name: failed_jobs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: roost
--

ALTER SEQUENCE public.failed_jobs_id_seq OWNED BY public.failed_jobs.id;


--
-- Name: jobs; Type: TABLE; Schema: public; Owner: roost
--

CREATE TABLE public.jobs (
    id bigint NOT NULL,
    queue character varying(255) NOT NULL,
    payload text NOT NULL,
    attempts smallint NOT NULL,
    reserved_at integer,
    available_at integer NOT NULL,
    created_at integer NOT NULL
);


ALTER TABLE public.jobs OWNER TO roost;

--
-- Name: jobs_id_seq; Type: SEQUENCE; Schema: public; Owner: roost
--

CREATE SEQUENCE public.jobs_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.jobs_id_seq OWNER TO roost;

--
-- Name: jobs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: roost
--

ALTER SEQUENCE public.jobs_id_seq OWNED BY public.jobs.id;


--
-- Name: migrations; Type: TABLE; Schema: public; Owner: roost
--

CREATE TABLE public.migrations (
    id integer NOT NULL,
    migration character varying(255) NOT NULL,
    batch integer NOT NULL
);


ALTER TABLE public.migrations OWNER TO roost;

--
-- Name: migrations_id_seq; Type: SEQUENCE; Schema: public; Owner: roost
--

CREATE SEQUENCE public.migrations_id_seq
    AS integer
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.migrations_id_seq OWNER TO roost;

--
-- Name: migrations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: roost
--

ALTER SEQUENCE public.migrations_id_seq OWNED BY public.migrations.id;


--
-- Name: password_reset_tokens; Type: TABLE; Schema: public; Owner: roost
--

CREATE TABLE public.password_reset_tokens (
    email character varying(255) NOT NULL,
    token character varying(255) NOT NULL,
    created_at timestamp(0) without time zone
);


ALTER TABLE public.password_reset_tokens OWNER TO roost;

--
-- Name: posts; Type: TABLE; Schema: public; Owner: roost
--

CREATE TABLE public.posts (
    id bigint NOT NULL,
    category_id bigint NOT NULL,
    user_id bigint NOT NULL,
    title character varying(255) NOT NULL,
    slug character varying(255) NOT NULL,
    body text,
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    deleted_at timestamp(0) without time zone
);


ALTER TABLE public.posts OWNER TO roost;

--
-- Name: posts_id_seq; Type: SEQUENCE; Schema: public; Owner: roost
--

CREATE SEQUENCE public.posts_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.posts_id_seq OWNER TO roost;

--
-- Name: posts_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: roost
--

ALTER SEQUENCE public.posts_id_seq OWNED BY public.posts.id;


--
-- Name: users; Type: TABLE; Schema: public; Owner: roost
--

CREATE TABLE public.users (
    id bigint NOT NULL,
    name character varying(255),
    email character varying(255) NOT NULL,
    password character varying(255),
    created_at timestamp(0) without time zone,
    updated_at timestamp(0) without time zone,
    remember_token character varying(100),
    deleted_at timestamp(0) without time zone
);


ALTER TABLE public.users OWNER TO roost;

--
-- Name: users_id_seq; Type: SEQUENCE; Schema: public; Owner: roost
--

CREATE SEQUENCE public.users_id_seq
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER SEQUENCE public.users_id_seq OWNER TO roost;

--
-- Name: users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: roost
--

ALTER SEQUENCE public.users_id_seq OWNED BY public.users.id;


--
-- Name: categories id; Type: DEFAULT; Schema: public; Owner: roost
--

ALTER TABLE ONLY public.categories ALTER COLUMN id SET DEFAULT nextval('public.categories_id_seq'::regclass);


--
-- Name: failed_jobs id; Type: DEFAULT; Schema: public; Owner: roost
--

ALTER TABLE ONLY public.failed_jobs ALTER COLUMN id SET DEFAULT nextval('public.failed_jobs_id_seq'::regclass);


--
-- Name: jobs id; Type: DEFAULT; Schema: public; Owner: roost
--

ALTER TABLE ONLY public.jobs ALTER COLUMN id SET DEFAULT nextval('public.jobs_id_seq'::regclass);


--
-- Name: migrations id; Type: DEFAULT; Schema: public; Owner: roost
--

ALTER TABLE ONLY public.migrations ALTER COLUMN id SET DEFAULT nextval('public.migrations_id_seq'::regclass);


--
-- Name: posts id; Type: DEFAULT; Schema: public; Owner: roost
--

ALTER TABLE ONLY public.posts ALTER COLUMN id SET DEFAULT nextval('public.posts_id_seq'::regclass);


--
-- Name: users id; Type: DEFAULT; Schema: public; Owner: roost
--

ALTER TABLE ONLY public.users ALTER COLUMN id SET DEFAULT nextval('public.users_id_seq'::regclass);


--
-- Data for Name: categories; Type: TABLE DATA; Schema: public; Owner: roost
--

INSERT INTO public.categories VALUES (1, 'Cat1', 'cat1', '2025-02-28 21:04:17', '2025-02-28 21:04:17', NULL);
INSERT INTO public.categories VALUES (2, 'Cat', 'cat2', '2025-02-28 21:05:00', '2025-02-28 21:05:00', NULL);
INSERT INTO public.categories VALUES (3, 'Cat3', 'cat3', '2025-02-28 21:05:40', '2025-02-28 21:05:40', NULL);
INSERT INTO public.categories VALUES (4, 'Cat4', 'cat4', '2025-02-28 21:06:51', '2025-02-28 21:06:51', NULL);
INSERT INTO public.categories VALUES (5, 'Cat8', 'cat8', '2025-02-28 21:07:37', '2025-02-28 21:11:02', NULL);


--
-- Data for Name: failed_jobs; Type: TABLE DATA; Schema: public; Owner: roost
--

INSERT INTO public.failed_jobs VALUES (1, '7873e353-9a98-46e2-889b-913e4ebce5eb', 'database', 'default', '{"uuid":"7873e353-9a98-46e2-889b-913e4ebce5eb","displayName":"App\\Notifications\\SendOtpNotification","job":"Illuminate\\Queue\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"Illuminate\\Notifications\\SendQueuedNotifications","command":"O:48:\"Illuminate\\Notifications\\SendQueuedNotifications\":3:{s:11:\"notifiables\";O:45:\"Illuminate\\Contracts\\Database\\ModelIdentifier\":5:{s:5:\"class\";s:15:\"App\\Models\\User\";s:2:\"id\";a:1:{i:0;i:5;}s:9:\"relations\";a:0:{}s:10:\"connection\";s:5:\"pgsql\";s:15:\"collectionClass\";N;}s:12:\"notification\";O:37:\"App\\Notifications\\SendOtpNotification\":3:{s:8:\"\u0000*\u0000email\";s:25:\"mimdeveloper.tv@gmail.com\";s:6:\"\u0000*\u0000otp\";s:6:\"534654\";s:2:\"id\";s:36:\"e7c66653-65cf-4ccd-ad10-26014b5ac024\";}s:8:\"channels\";a:1:{i:0;s:4:\"mail\";}}"}}', 'InvalidArgumentException: Mailer [mail.mailers.smtp] is not defined. in /var/www/vendor/laravel/framework/src/Illuminate/Mail/MailManager.php:117
Stack trace:
#0 /var/www/vendor/laravel/framework/src/Illuminate/Mail/MailManager.php(101): Illuminate\Mail\MailManager->resolve(''mail.mailers.sm...'')
#1 /var/www/vendor/laravel/framework/src/Illuminate/Mail/MailManager.php(79): Illuminate\Mail\MailManager->get(''mail.mailers.sm...'')
#2 /var/www/vendor/laravel/framework/src/Illuminate/Mail/Mailable.php(203): Illuminate\Mail\MailManager->mailer(''mail.mailers.sm...'')
#3 /var/www/vendor/laravel/framework/src/Illuminate/Support/Traits/Localizable.php(19): Illuminate\Mail\Mailable->Illuminate\Mail\{closure}()
#4 /var/www/vendor/laravel/framework/src/Illuminate/Mail/Mailable.php(199): Illuminate\Mail\Mailable->withLocale(NULL, Object(Closure))
#5 /var/www/vendor/laravel/framework/src/Illuminate/Notifications/Channels/MailChannel.php(64): Illuminate\Mail\Mailable->send(Object(Illuminate\Mail\MailManager))
#6 /var/www/vendor/laravel/framework/src/Illuminate/Notifications/NotificationSender.php(148): Illuminate\Notifications\Channels\MailChannel->send(Object(App\Models\User), Object(App\Notifications\SendOtpNotification))
#7 /var/www/vendor/laravel/framework/src/Illuminate/Notifications/NotificationSender.php(106): Illuminate\Notifications\NotificationSender->sendToNotifiable(Object(App\Models\User), ''c58e3fed-3ab0-4...'', Object(App\Notifications\SendOtpNotification), ''mail'')
#8 /var/www/vendor/laravel/framework/src/Illuminate/Support/Traits/Localizable.php(19): Illuminate\Notifications\NotificationSender->Illuminate\Notifications\{closure}()
#9 /var/www/vendor/laravel/framework/src/Illuminate/Notifications/NotificationSender.php(101): Illuminate\Notifications\NotificationSender->withLocale(NULL, Object(Closure))
#10 /var/www/vendor/laravel/framework/src/Illuminate/Notifications/ChannelManager.php(54): Illuminate\Notifications\NotificationSender->sendNow(Object(Illuminate\Database\Eloquent\Collection), Object(App\Notifications\SendOtpNotification), Array)
#11 /var/www/vendor/laravel/framework/src/Illuminate/Notifications/SendQueuedNotifications.php(119): Illuminate\Notifications\ChannelManager->sendNow(Object(Illuminate\Database\Eloquent\Collection), Object(App\Notifications\SendOtpNotification), Array)
#12 /var/www/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(36): Illuminate\Notifications\SendQueuedNotifications->handle(Object(Illuminate\Notifications\ChannelManager))
#13 /var/www/vendor/laravel/framework/src/Illuminate/Container/Util.php(43): Illuminate\Container\BoundMethod::Illuminate\Container\{closure}()
#14 /var/www/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(95): Illuminate\Container\Util::unwrapIfClosure(Object(Closure))
#15 /var/www/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(35): Illuminate\Container\BoundMethod::callBoundMethod(Object(Illuminate\Foundation\Application), Array, Object(Closure))
#16 /var/www/vendor/laravel/framework/src/Illuminate/Container/Container.php(696): Illuminate\Container\BoundMethod::call(Object(Illuminate\Foundation\Application), Array, Array, NULL)
#17 /var/www/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(126): Illuminate\Container\Container->call(Array)
#18 /var/www/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(170): Illuminate\Bus\Dispatcher->Illuminate\Bus\{closure}(Object(Illuminate\Notifications\SendQueuedNotifications))
#19 /var/www/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(127): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}(Object(Illuminate\Notifications\SendQueuedNotifications))
#20 /var/www/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(130): Illuminate\Pipeline\Pipeline->then(Object(Closure))
#21 /var/www/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(126): Illuminate\Bus\Dispatcher->dispatchNow(Object(Illuminate\Notifications\SendQueuedNotifications), false)
#22 /var/www/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(170): Illuminate\Queue\CallQueuedHandler->Illuminate\Queue\{closure}(Object(Illuminate\Notifications\SendQueuedNotifications))
#23 /var/www/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(127): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}(Object(Illuminate\Notifications\SendQueuedNotifications))
#24 /var/www/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(121): Illuminate\Pipeline\Pipeline->then(Object(Closure))
#25 /var/www/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(69): Illuminate\Queue\CallQueuedHandler->dispatchThroughMiddleware(Object(Illuminate\Queue\Jobs\DatabaseJob), Object(Illuminate\Notifications\SendQueuedNotifications))
#26 /var/www/vendor/laravel/framework/src/Illuminate/Queue/Jobs/Job.php(102): Illuminate\Queue\CallQueuedHandler->call(Object(Illuminate\Queue\Jobs\DatabaseJob), Array)
#27 /var/www/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(442): Illuminate\Queue\Jobs\Job->fire()
#28 /var/www/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(392): Illuminate\Queue\Worker->process(''database'', Object(Illuminate\Queue\Jobs\DatabaseJob), Object(Illuminate\Queue\WorkerOptions))
#29 /var/www/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(178): Illuminate\Queue\Worker->runJob(Object(Illuminate\Queue\Jobs\DatabaseJob), ''database'', Object(Illuminate\Queue\WorkerOptions))
#30 /var/www/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(149): Illuminate\Queue\Worker->daemon(''database'', ''default'', Object(Illuminate\Queue\WorkerOptions))
#31 /var/www/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(132): Illuminate\Queue\Console\WorkCommand->runWorker(''database'', ''default'')
#32 /var/www/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(36): Illuminate\Queue\Console\WorkCommand->handle()
#33 /var/www/vendor/laravel/framework/src/Illuminate/Container/Util.php(43): Illuminate\Container\BoundMethod::Illuminate\Container\{closure}()
#34 /var/www/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(95): Illuminate\Container\Util::unwrapIfClosure(Object(Closure))
#35 /var/www/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(35): Illuminate\Container\BoundMethod::callBoundMethod(Object(Illuminate\Foundation\Application), Array, Object(Closure))
#36 /var/www/vendor/laravel/framework/src/Illuminate/Container/Container.php(696): Illuminate\Container\BoundMethod::call(Object(Illuminate\Foundation\Application), Array, Array, NULL)
#37 /var/www/vendor/laravel/framework/src/Illuminate/Console/Command.php(213): Illuminate\Container\Container->call(Array)
#38 /var/www/vendor/symfony/console/Command/Command.php(279): Illuminate\Console\Command->execute(Object(Symfony\Component\Console\Input\ArgvInput), Object(Illuminate\Console\OutputStyle))
#39 /var/www/vendor/laravel/framework/src/Illuminate/Console/Command.php(182): Symfony\Component\Console\Command\Command->run(Object(Symfony\Component\Console\Input\ArgvInput), Object(Illuminate\Console\OutputStyle))
#40 /var/www/vendor/symfony/console/Application.php(1094): Illuminate\Console\Command->run(Object(Symfony\Component\Console\Input\ArgvInput), Object(Symfony\Component\Console\Output\ConsoleOutput))
#41 /var/www/vendor/symfony/console/Application.php(342): Symfony\Component\Console\Application->doRunCommand(Object(Illuminate\Queue\Console\WorkCommand), Object(Symfony\Component\Console\Input\ArgvInput), Object(Symfony\Component\Console\Output\ConsoleOutput))
#42 /var/www/vendor/symfony/console/Application.php(193): Symfony\Component\Console\Application->doRun(Object(Symfony\Component\Console\Input\ArgvInput), Object(Symfony\Component\Console\Output\ConsoleOutput))
#43 /var/www/vendor/laravel/framework/src/Illuminate/Foundation/Console/Kernel.php(198): Symfony\Component\Console\Application->run(Object(Symfony\Component\Console\Input\ArgvInput), Object(Symfony\Component\Console\Output\ConsoleOutput))
#44 /var/www/artisan(35): Illuminate\Foundation\Console\Kernel->handle(Object(Symfony\Component\Console\Input\ArgvInput), Object(Symfony\Component\Console\Output\ConsoleOutput))
#45 {main}', '2025-02-28 12:47:00');
INSERT INTO public.failed_jobs VALUES (2, '5b0dfb58-aa9f-4a3a-84c9-fa47362aa87c', 'database', 'default', '{"uuid":"5b0dfb58-aa9f-4a3a-84c9-fa47362aa87c","displayName":"App\\Notifications\\SendOtpNotification","job":"Illuminate\\Queue\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"Illuminate\\Notifications\\SendQueuedNotifications","command":"O:48:\"Illuminate\\Notifications\\SendQueuedNotifications\":3:{s:11:\"notifiables\";O:45:\"Illuminate\\Contracts\\Database\\ModelIdentifier\":5:{s:5:\"class\";s:15:\"App\\Models\\User\";s:2:\"id\";a:1:{i:0;i:5;}s:9:\"relations\";a:0:{}s:10:\"connection\";s:5:\"pgsql\";s:15:\"collectionClass\";N;}s:12:\"notification\";O:37:\"App\\Notifications\\SendOtpNotification\":3:{s:8:\"\u0000*\u0000email\";s:25:\"mimdeveloper.tv@gmail.com\";s:6:\"\u0000*\u0000otp\";s:6:\"655417\";s:2:\"id\";s:36:\"557e91c5-b3ab-41f8-b113-284bf9e5ced3\";}s:8:\"channels\";a:1:{i:0;s:4:\"mail\";}}"}}', 'InvalidArgumentException: Mailer [mail.mailers.smtp] is not defined. in /var/www/vendor/laravel/framework/src/Illuminate/Mail/MailManager.php:117
Stack trace:
#0 /var/www/vendor/laravel/framework/src/Illuminate/Mail/MailManager.php(101): Illuminate\Mail\MailManager->resolve(''mail.mailers.sm...'')
#1 /var/www/vendor/laravel/framework/src/Illuminate/Mail/MailManager.php(79): Illuminate\Mail\MailManager->get(''mail.mailers.sm...'')
#2 /var/www/vendor/laravel/framework/src/Illuminate/Mail/Mailable.php(203): Illuminate\Mail\MailManager->mailer(''mail.mailers.sm...'')
#3 /var/www/vendor/laravel/framework/src/Illuminate/Support/Traits/Localizable.php(19): Illuminate\Mail\Mailable->Illuminate\Mail\{closure}()
#4 /var/www/vendor/laravel/framework/src/Illuminate/Mail/Mailable.php(199): Illuminate\Mail\Mailable->withLocale(NULL, Object(Closure))
#5 /var/www/vendor/laravel/framework/src/Illuminate/Notifications/Channels/MailChannel.php(64): Illuminate\Mail\Mailable->send(Object(Illuminate\Mail\MailManager))
#6 /var/www/vendor/laravel/framework/src/Illuminate/Notifications/NotificationSender.php(148): Illuminate\Notifications\Channels\MailChannel->send(Object(App\Models\User), Object(App\Notifications\SendOtpNotification))
#7 /var/www/vendor/laravel/framework/src/Illuminate/Notifications/NotificationSender.php(106): Illuminate\Notifications\NotificationSender->sendToNotifiable(Object(App\Models\User), ''f3f3c40d-de84-4...'', Object(App\Notifications\SendOtpNotification), ''mail'')
#8 /var/www/vendor/laravel/framework/src/Illuminate/Support/Traits/Localizable.php(19): Illuminate\Notifications\NotificationSender->Illuminate\Notifications\{closure}()
#9 /var/www/vendor/laravel/framework/src/Illuminate/Notifications/NotificationSender.php(101): Illuminate\Notifications\NotificationSender->withLocale(NULL, Object(Closure))
#10 /var/www/vendor/laravel/framework/src/Illuminate/Notifications/ChannelManager.php(54): Illuminate\Notifications\NotificationSender->sendNow(Object(Illuminate\Database\Eloquent\Collection), Object(App\Notifications\SendOtpNotification), Array)
#11 /var/www/vendor/laravel/framework/src/Illuminate/Notifications/SendQueuedNotifications.php(119): Illuminate\Notifications\ChannelManager->sendNow(Object(Illuminate\Database\Eloquent\Collection), Object(App\Notifications\SendOtpNotification), Array)
#12 /var/www/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(36): Illuminate\Notifications\SendQueuedNotifications->handle(Object(Illuminate\Notifications\ChannelManager))
#13 /var/www/vendor/laravel/framework/src/Illuminate/Container/Util.php(43): Illuminate\Container\BoundMethod::Illuminate\Container\{closure}()
#14 /var/www/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(95): Illuminate\Container\Util::unwrapIfClosure(Object(Closure))
#15 /var/www/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(35): Illuminate\Container\BoundMethod::callBoundMethod(Object(Illuminate\Foundation\Application), Array, Object(Closure))
#16 /var/www/vendor/laravel/framework/src/Illuminate/Container/Container.php(696): Illuminate\Container\BoundMethod::call(Object(Illuminate\Foundation\Application), Array, Array, NULL)
#17 /var/www/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(126): Illuminate\Container\Container->call(Array)
#18 /var/www/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(170): Illuminate\Bus\Dispatcher->Illuminate\Bus\{closure}(Object(Illuminate\Notifications\SendQueuedNotifications))
#19 /var/www/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(127): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}(Object(Illuminate\Notifications\SendQueuedNotifications))
#20 /var/www/vendor/laravel/framework/src/Illuminate/Bus/Dispatcher.php(130): Illuminate\Pipeline\Pipeline->then(Object(Closure))
#21 /var/www/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(126): Illuminate\Bus\Dispatcher->dispatchNow(Object(Illuminate\Notifications\SendQueuedNotifications), false)
#22 /var/www/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(170): Illuminate\Queue\CallQueuedHandler->Illuminate\Queue\{closure}(Object(Illuminate\Notifications\SendQueuedNotifications))
#23 /var/www/vendor/laravel/framework/src/Illuminate/Pipeline/Pipeline.php(127): Illuminate\Pipeline\Pipeline->Illuminate\Pipeline\{closure}(Object(Illuminate\Notifications\SendQueuedNotifications))
#24 /var/www/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(121): Illuminate\Pipeline\Pipeline->then(Object(Closure))
#25 /var/www/vendor/laravel/framework/src/Illuminate/Queue/CallQueuedHandler.php(69): Illuminate\Queue\CallQueuedHandler->dispatchThroughMiddleware(Object(Illuminate\Queue\Jobs\DatabaseJob), Object(Illuminate\Notifications\SendQueuedNotifications))
#26 /var/www/vendor/laravel/framework/src/Illuminate/Queue/Jobs/Job.php(102): Illuminate\Queue\CallQueuedHandler->call(Object(Illuminate\Queue\Jobs\DatabaseJob), Array)
#27 /var/www/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(442): Illuminate\Queue\Jobs\Job->fire()
#28 /var/www/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(392): Illuminate\Queue\Worker->process(''database'', Object(Illuminate\Queue\Jobs\DatabaseJob), Object(Illuminate\Queue\WorkerOptions))
#29 /var/www/vendor/laravel/framework/src/Illuminate/Queue/Worker.php(178): Illuminate\Queue\Worker->runJob(Object(Illuminate\Queue\Jobs\DatabaseJob), ''database'', Object(Illuminate\Queue\WorkerOptions))
#30 /var/www/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(149): Illuminate\Queue\Worker->daemon(''database'', ''default'', Object(Illuminate\Queue\WorkerOptions))
#31 /var/www/vendor/laravel/framework/src/Illuminate/Queue/Console/WorkCommand.php(132): Illuminate\Queue\Console\WorkCommand->runWorker(''database'', ''default'')
#32 /var/www/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(36): Illuminate\Queue\Console\WorkCommand->handle()
#33 /var/www/vendor/laravel/framework/src/Illuminate/Container/Util.php(43): Illuminate\Container\BoundMethod::Illuminate\Container\{closure}()
#34 /var/www/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(95): Illuminate\Container\Util::unwrapIfClosure(Object(Closure))
#35 /var/www/vendor/laravel/framework/src/Illuminate/Container/BoundMethod.php(35): Illuminate\Container\BoundMethod::callBoundMethod(Object(Illuminate\Foundation\Application), Array, Object(Closure))
#36 /var/www/vendor/laravel/framework/src/Illuminate/Container/Container.php(696): Illuminate\Container\BoundMethod::call(Object(Illuminate\Foundation\Application), Array, Array, NULL)
#37 /var/www/vendor/laravel/framework/src/Illuminate/Console/Command.php(213): Illuminate\Container\Container->call(Array)
#38 /var/www/vendor/symfony/console/Command/Command.php(279): Illuminate\Console\Command->execute(Object(Symfony\Component\Console\Input\ArgvInput), Object(Illuminate\Console\OutputStyle))
#39 /var/www/vendor/laravel/framework/src/Illuminate/Console/Command.php(182): Symfony\Component\Console\Command\Command->run(Object(Symfony\Component\Console\Input\ArgvInput), Object(Illuminate\Console\OutputStyle))
#40 /var/www/vendor/symfony/console/Application.php(1094): Illuminate\Console\Command->run(Object(Symfony\Component\Console\Input\ArgvInput), Object(Symfony\Component\Console\Output\ConsoleOutput))
#41 /var/www/vendor/symfony/console/Application.php(342): Symfony\Component\Console\Application->doRunCommand(Object(Illuminate\Queue\Console\WorkCommand), Object(Symfony\Component\Console\Input\ArgvInput), Object(Symfony\Component\Console\Output\ConsoleOutput))
#42 /var/www/vendor/symfony/console/Application.php(193): Symfony\Component\Console\Application->doRun(Object(Symfony\Component\Console\Input\ArgvInput), Object(Symfony\Component\Console\Output\ConsoleOutput))
#43 /var/www/vendor/laravel/framework/src/Illuminate/Foundation/Console/Kernel.php(198): Symfony\Component\Console\Application->run(Object(Symfony\Component\Console\Input\ArgvInput), Object(Symfony\Component\Console\Output\ConsoleOutput))
#44 /var/www/artisan(35): Illuminate\Foundation\Console\Kernel->handle(Object(Symfony\Component\Console\Input\ArgvInput), Object(Symfony\Component\Console\Output\ConsoleOutput))
#45 {main}', '2025-02-28 12:55:13');


--
-- Data for Name: jobs; Type: TABLE DATA; Schema: public; Owner: roost
--

INSERT INTO public.jobs VALUES (11, 'default', '{"uuid":"ce5b4801-ccd4-424d-bbf1-b6fb6e0bf2f4","displayName":"App\\Notifications\\SendOtpNotification","job":"Illuminate\\Queue\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"Illuminate\\Notifications\\SendQueuedNotifications","command":"O:48:\"Illuminate\\Notifications\\SendQueuedNotifications\":3:{s:11:\"notifiables\";O:45:\"Illuminate\\Contracts\\Database\\ModelIdentifier\":5:{s:5:\"class\";s:15:\"App\\Models\\User\";s:2:\"id\";a:1:{i:0;i:11;}s:9:\"relations\";a:0:{}s:10:\"connection\";s:5:\"pgsql\";s:15:\"collectionClass\";N;}s:12:\"notification\";O:37:\"App\\Notifications\\SendOtpNotification\":3:{s:8:\"\u0000*\u0000email\";s:20:\"mohammad@digiland.ir\";s:6:\"\u0000*\u0000otp\";s:6:\"708659\";s:2:\"id\";s:36:\"91b48c6d-522b-4ca4-9f8f-f48372b19ec9\";}s:8:\"channels\";a:1:{i:0;s:4:\"mail\";}}"}}', 0, NULL, 1740751756, 1740751756);
INSERT INTO public.jobs VALUES (12, 'default', '{"uuid":"34c8cb5c-f20c-425e-b097-375d8dc80d2a","displayName":"App\\Notifications\\SendOtpNotification","job":"Illuminate\\Queue\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"Illuminate\\Notifications\\SendQueuedNotifications","command":"O:48:\"Illuminate\\Notifications\\SendQueuedNotifications\":3:{s:11:\"notifiables\";O:45:\"Illuminate\\Contracts\\Database\\ModelIdentifier\":5:{s:5:\"class\";s:15:\"App\\Models\\User\";s:2:\"id\";a:1:{i:0;i:12;}s:9:\"relations\";a:0:{}s:10:\"connection\";s:5:\"pgsql\";s:15:\"collectionClass\";N;}s:12:\"notification\";O:37:\"App\\Notifications\\SendOtpNotification\":3:{s:8:\"\u0000*\u0000email\";s:21:\"mohammad1@digiland.ir\";s:6:\"\u0000*\u0000otp\";s:6:\"598092\";s:2:\"id\";s:36:\"9bd6f840-4465-44aa-a8a4-f20d0dc1773c\";}s:8:\"channels\";a:1:{i:0;s:4:\"mail\";}}"}}', 0, NULL, 1740754438, 1740754438);
INSERT INTO public.jobs VALUES (13, 'default', '{"uuid":"f44253e4-28fa-40dd-9f59-b33bed283a7c","displayName":"App\\Notifications\\SendOtpNotification","job":"Illuminate\\Queue\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"Illuminate\\Notifications\\SendQueuedNotifications","command":"O:48:\"Illuminate\\Notifications\\SendQueuedNotifications\":3:{s:11:\"notifiables\";O:45:\"Illuminate\\Contracts\\Database\\ModelIdentifier\":5:{s:5:\"class\";s:15:\"App\\Models\\User\";s:2:\"id\";a:1:{i:0;i:13;}s:9:\"relations\";a:0:{}s:10:\"connection\";s:5:\"pgsql\";s:15:\"collectionClass\";N;}s:12:\"notification\";O:37:\"App\\Notifications\\SendOtpNotification\":3:{s:8:\"\u0000*\u0000email\";s:21:\"mohammad2@digiland.ir\";s:6:\"\u0000*\u0000otp\";s:6:\"457034\";s:2:\"id\";s:36:\"84516412-36a5-4236-bc27-374d0dd93e8b\";}s:8:\"channels\";a:1:{i:0;s:4:\"mail\";}}"}}', 0, NULL, 1740754692, 1740754692);
INSERT INTO public.jobs VALUES (14, 'default', '{"uuid":"5611b4ab-29a9-480d-808e-d57759b44f3d","displayName":"App\\Notifications\\SendOtpNotification","job":"Illuminate\\Queue\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"Illuminate\\Notifications\\SendQueuedNotifications","command":"O:48:\"Illuminate\\Notifications\\SendQueuedNotifications\":3:{s:11:\"notifiables\";O:45:\"Illuminate\\Contracts\\Database\\ModelIdentifier\":5:{s:5:\"class\";s:15:\"App\\Models\\User\";s:2:\"id\";a:1:{i:0;i:13;}s:9:\"relations\";a:0:{}s:10:\"connection\";s:5:\"pgsql\";s:15:\"collectionClass\";N;}s:12:\"notification\";O:37:\"App\\Notifications\\SendOtpNotification\":3:{s:8:\"\u0000*\u0000email\";s:21:\"mohammad2@digiland.ir\";s:6:\"\u0000*\u0000otp\";s:6:\"355700\";s:2:\"id\";s:36:\"7bcfb975-3eef-4b9f-b9a1-18fd0b51076e\";}s:8:\"channels\";a:1:{i:0;s:4:\"mail\";}}"}}', 0, NULL, 1740774823, 1740774823);
INSERT INTO public.jobs VALUES (15, 'default', '{"uuid":"fcef33f3-404f-4cd6-a726-b29e09f4bbe4","displayName":"App\\Notifications\\SendOtpNotification","job":"Illuminate\\Queue\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"Illuminate\\Notifications\\SendQueuedNotifications","command":"O:48:\"Illuminate\\Notifications\\SendQueuedNotifications\":3:{s:11:\"notifiables\";O:45:\"Illuminate\\Contracts\\Database\\ModelIdentifier\":5:{s:5:\"class\";s:15:\"App\\Models\\User\";s:2:\"id\";a:1:{i:0;i:11;}s:9:\"relations\";a:0:{}s:10:\"connection\";s:5:\"pgsql\";s:15:\"collectionClass\";N;}s:12:\"notification\";O:37:\"App\\Notifications\\SendOtpNotification\":3:{s:8:\"\u0000*\u0000email\";s:20:\"mohammad@digiland.ir\";s:6:\"\u0000*\u0000otp\";s:6:\"262085\";s:2:\"id\";s:36:\"e3d82d1d-d0cb-4696-892c-6ba98eadd42b\";}s:8:\"channels\";a:1:{i:0;s:4:\"mail\";}}"}}', 0, NULL, 1740774829, 1740774829);
INSERT INTO public.jobs VALUES (16, 'default', '{"uuid":"4421cdee-b20d-4870-a945-dacbc48d7883","displayName":"App\\Notifications\\SendOtpNotification","job":"Illuminate\\Queue\\CallQueuedHandler@call","maxTries":null,"maxExceptions":null,"failOnTimeout":false,"backoff":null,"timeout":null,"retryUntil":null,"data":{"commandName":"Illuminate\\Notifications\\SendQueuedNotifications","command":"O:48:\"Illuminate\\Notifications\\SendQueuedNotifications\":3:{s:11:\"notifiables\";O:45:\"Illuminate\\Contracts\\Database\\ModelIdentifier\":5:{s:5:\"class\";s:15:\"App\\Models\\User\";s:2:\"id\";a:1:{i:0;i:11;}s:9:\"relations\";a:0:{}s:10:\"connection\";s:5:\"pgsql\";s:15:\"collectionClass\";N;}s:12:\"notification\";O:37:\"App\\Notifications\\SendOtpNotification\":3:{s:8:\"\u0000*\u0000email\";s:20:\"mohammad@digiland.ir\";s:6:\"\u0000*\u0000otp\";s:6:\"210852\";s:2:\"id\";s:36:\"eafc2c00-ba65-474f-88b4-6dcc06d02874\";}s:8:\"channels\";a:1:{i:0;s:4:\"mail\";}}"}}', 0, NULL, 1740774959, 1740774959);


--
-- Data for Name: migrations; Type: TABLE DATA; Schema: public; Owner: roost
--

INSERT INTO public.migrations VALUES (1, '2014_10_12_000000_create_users_table', 1);
INSERT INTO public.migrations VALUES (2, '2014_10_12_100000_create_password_reset_tokens_table', 1);
INSERT INTO public.migrations VALUES (3, '2019_08_19_000000_create_failed_jobs_table', 1);
INSERT INTO public.migrations VALUES (6, '2025_02_28_120317_create_jobs_table', 2);
INSERT INTO public.migrations VALUES (7, '2025_02_27_130312_create_categories_table', 3);
INSERT INTO public.migrations VALUES (8, '2025_02_27_130438_create_posts_table', 3);


--
-- Data for Name: password_reset_tokens; Type: TABLE DATA; Schema: public; Owner: roost
--



--
-- Data for Name: posts; Type: TABLE DATA; Schema: public; Owner: roost
--

INSERT INTO public.posts VALUES (43, 1, 1, 'Cat1', 'cat1', 'hey are you ok', '2025-03-01 01:37:26', '2025-03-01 01:37:26', NULL);
INSERT INTO public.posts VALUES (44, 1, 1, 'Cat2', 'cat2', 'hey are you ok', '2025-03-01 01:37:33', '2025-03-01 01:37:33', NULL);
INSERT INTO public.posts VALUES (45, 1, 2, 'Cat3', 'cat3', 'hey are you ok', '2025-03-01 01:37:41', '2025-03-01 01:37:41', NULL);
INSERT INTO public.posts VALUES (46, 1, 1, 'Cat4', 'cat4', 'can hey are you', '2025-03-01 01:38:49', '2025-03-01 01:38:49', NULL);
INSERT INTO public.posts VALUES (47, 1, 1, 'Cat5', 'cat5', 'can hey are mohammad', '2025-03-01 01:39:03', '2025-03-01 01:39:03', NULL);


--
-- Data for Name: users; Type: TABLE DATA; Schema: public; Owner: roost
--

INSERT INTO public.users VALUES (1, NULL, 'moh@shab.ir', NULL, '2025-02-27 21:54:59', '2025-02-27 21:54:59', NULL, NULL);
INSERT INTO public.users VALUES (2, NULL, 'moh1@shab.ir', NULL, '2025-02-27 21:56:51', '2025-02-27 21:56:51', NULL, NULL);
INSERT INTO public.users VALUES (13, 'max', 'mohammad2@digiland.ir', '$2y$12$5iCvHSQ60vAATWYaVXrtau3tXQmGvl5XgV4YcVjtVrADnxlEurVyi', '2025-02-28 14:58:12', '2025-02-28 14:58:23', NULL, NULL);
INSERT INTO public.users VALUES (11, NULL, 'mohammad@digiland.ir', '$2y$12$Z0czHYHzETbA9KDrCDfg9OxXJ3PGRS0M7W545.SlR9/HDX.j44pSK', '2025-02-28 14:09:16', '2025-02-28 20:36:23', NULL, NULL);
INSERT INTO public.users VALUES (3, 'max', 'mohammad1@digiland.ir', '$2y$12$pWJGmx/R1SN0hmW6DNTqEuMORLZh.CxPGh4139wVP3thcmWqVS8o2', '2025-02-28 14:53:58', '2025-02-28 14:55:37', NULL, NULL);


--
-- Name: categories_id_seq; Type: SEQUENCE SET; Schema: public; Owner: roost
--

SELECT pg_catalog.setval('public.categories_id_seq', 5, true);


--
-- Name: failed_jobs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: roost
--

SELECT pg_catalog.setval('public.failed_jobs_id_seq', 2, true);


--
-- Name: jobs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: roost
--

SELECT pg_catalog.setval('public.jobs_id_seq', 16, true);


--
-- Name: migrations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: roost
--

SELECT pg_catalog.setval('public.migrations_id_seq', 8, true);


--
-- Name: posts_id_seq; Type: SEQUENCE SET; Schema: public; Owner: roost
--

SELECT pg_catalog.setval('public.posts_id_seq', 47, true);


--
-- Name: users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: roost
--

SELECT pg_catalog.setval('public.users_id_seq', 13, true);


--
-- Name: categories categories_pkey; Type: CONSTRAINT; Schema: public; Owner: roost
--

ALTER TABLE ONLY public.categories
    ADD CONSTRAINT categories_pkey PRIMARY KEY (id);


--
-- Name: categories categories_slug_unique; Type: CONSTRAINT; Schema: public; Owner: roost
--

ALTER TABLE ONLY public.categories
    ADD CONSTRAINT categories_slug_unique UNIQUE (slug);


--
-- Name: failed_jobs failed_jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: roost
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_pkey PRIMARY KEY (id);


--
-- Name: failed_jobs failed_jobs_uuid_unique; Type: CONSTRAINT; Schema: public; Owner: roost
--

ALTER TABLE ONLY public.failed_jobs
    ADD CONSTRAINT failed_jobs_uuid_unique UNIQUE (uuid);


--
-- Name: jobs jobs_pkey; Type: CONSTRAINT; Schema: public; Owner: roost
--

ALTER TABLE ONLY public.jobs
    ADD CONSTRAINT jobs_pkey PRIMARY KEY (id);


--
-- Name: migrations migrations_pkey; Type: CONSTRAINT; Schema: public; Owner: roost
--

ALTER TABLE ONLY public.migrations
    ADD CONSTRAINT migrations_pkey PRIMARY KEY (id);


--
-- Name: password_reset_tokens password_reset_tokens_pkey; Type: CONSTRAINT; Schema: public; Owner: roost
--

ALTER TABLE ONLY public.password_reset_tokens
    ADD CONSTRAINT password_reset_tokens_pkey PRIMARY KEY (email);


--
-- Name: posts posts_pkey; Type: CONSTRAINT; Schema: public; Owner: roost
--

ALTER TABLE ONLY public.posts
    ADD CONSTRAINT posts_pkey PRIMARY KEY (id);


--
-- Name: posts posts_slug_unique; Type: CONSTRAINT; Schema: public; Owner: roost
--

ALTER TABLE ONLY public.posts
    ADD CONSTRAINT posts_slug_unique UNIQUE (slug);


--
-- Name: users users_email_unique; Type: CONSTRAINT; Schema: public; Owner: roost
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_email_unique UNIQUE (email);


--
-- Name: users users_pkey; Type: CONSTRAINT; Schema: public; Owner: roost
--

ALTER TABLE ONLY public.users
    ADD CONSTRAINT users_pkey PRIMARY KEY (id);


--
-- Name: jobs_queue_index; Type: INDEX; Schema: public; Owner: roost
--

CREATE INDEX jobs_queue_index ON public.jobs USING btree (queue);


--
-- Name: posts posts_category_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: roost
--

ALTER TABLE ONLY public.posts
    ADD CONSTRAINT posts_category_id_foreign FOREIGN KEY (category_id) REFERENCES public.categories(id) ON DELETE SET NULL;


--
-- Name: posts posts_user_id_foreign; Type: FK CONSTRAINT; Schema: public; Owner: roost
--

ALTER TABLE ONLY public.posts
    ADD CONSTRAINT posts_user_id_foreign FOREIGN KEY (user_id) REFERENCES public.users(id) ON DELETE SET NULL;


--
-- PostgreSQL database dump complete
--

