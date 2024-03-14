<?php
namespace App\Command;

use Exception;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Input\InputArgument;



#[AsCommand(
    name: 'app:get-ptr-records',
    description: 'Returns by the domain name of the PTR record',
    hidden: false
)]
class GetPtrRecords extends Command
{
    protected function configure(): void
    {
        $this->addArgument('domain', InputArgument::REQUIRED, 'Input domain');
    }
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $domain = $input->getArgument('domain');
            //checking for the existence of a DNS record of type A
            if (dns_check_record($domain, 'A')) {
                $dnsRecords = dns_get_record($domain, DNS_MX);
                //checking for the existence of DNS records of the MX type
                if ($dnsRecords and array_key_exists("target", $dnsRecords[0])) {
                    //getting the mail server address and ip addresses
                    $mailServer = $dnsRecords[0]["target"];
                    $mailIpAddresses = gethostbynamel($mailServer);
                    //getting PTR records for each IP
                    foreach ($mailIpAddresses as $ip_address) {
                        //$prt_record = gethostbyaddr($ip_address);
                        $prt_record = dns_get_record(implode('.', array_reverse(explode('.', $ip_address))) . '.in-addr.arpa', DNS_PTR);
                        if ($prt_record and array_key_exists("target", $prt_record[0])) {
                            $target_prt = $prt_record[0]["target"];
                            $output->writeln("$ip_address, $target_prt");
                        }
                        else{
                            $output->writeln("$ip_address - failure");
                        }
                    }
                } else {
                    $output->writeln("Dns records with the MX type were not received");
                    return Command::FAILURE;
                }
                return Command::SUCCESS;
            } else {
                $output->writeln("The domain does not exist");
                return Command::FAILURE;
            }
        } catch (Exception $e) {
            $output->writeln("An error has occurred. Please check the following: $e");
            return Command::FAILURE;
        }
    }
}
